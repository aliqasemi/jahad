<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ErrorException;
use App\Helpers\CheckStepRelation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Step\StoreStepRequest;
use App\Http\Requests\Step\UpdateStepRequest;
use App\Http\Resources\StepResource;
use App\Models\Project;
use App\Models\Step;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StepController extends Controller
{

    use CheckStepRelation;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Project $project)
    {
        return StepResource::collection(
            Step::where('project_id', $project->id)->orderBy('sort', 'asc')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return StepResource
     */
    public function store(StoreStepRequest $request, Project $project)
    {
        $data = $request->validated();
        $maxSort = Step::where('project_id', $project->id)->max('sort');

        if (is_null($maxSort)) {
            Arr::set($data, 'sort', 1);
        } else {
            Arr::set($data, 'sort', $maxSort + 1);
        }

        $step = new Step($data);
        $user = User::findOrFail(Auth::id());
        $user->steps()->save($step);

        $step->save();

        return new StepResource(
            $step->load(['user', 'template'])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Step $step
     * @return StepResource
     */
    public function show(Step $step)
    {
        return new StepResource(
            $step->load(['user', 'template'])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStepRequest $request
     * @param Step $step
     * @return StepResource
     */
    public function update(UpdateStepRequest $request, Step $step): StepResource
    {
        $step = $step->fill($request->validated());

        $step->save();

        return new StepResource(
            $step->load(['user', 'template'])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Step $step
     * @return \Illuminate\Http\Response
     */
    public function destroy(Step $step): \Illuminate\Http\Response
    {
        if ($this->canDelete($step)) {
            $step->delete();
            return response('عملیات با موفقیت انجام شد');
        } else {
            return response('این مرحله توسط یک پروژه در حال انجام است');
        }
    }

    /**
     * @throws ErrorException
     */
    public function moveUp(Request $request, Step $step)
    {
        $sort = $step->sort;

        if ($sort > 1) {
            DB::transaction(function ($query) use ($sort, $step, $request) {
                Step::where('sort', $sort - 1)->update(['sort' => $sort]);
                $step->update(['sort' => $sort - 1]);
            });
            DB::commit();
            return response('ok');
        } else {
            return throw new ErrorException('step move up last');
        }
    }

    public function moveDown(Request $request, Step $step)
    {
        $sort = $step->sort;
        $maxSort = $step::max('sort');

        if ($sort < $maxSort) {
            DB::transaction(function ($query) use ($sort, $step, $request) {
                Step::where('sort', $sort + 1)->update(['sort' => $sort]);
                $step->update(['sort' => $sort + 1]);
            });
            DB::commit();
            return response('ok');
        } else {
            return throw new ErrorException('step move down last');
        }
    }
}
