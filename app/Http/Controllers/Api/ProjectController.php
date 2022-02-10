<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Step;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection(
            Project::filter(request())->with(['services', 'requirement', 'step'])->paginate(request('per_page'))
        );
    }

    public function indexFilter(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::filter(request())->with(['services', 'requirement'])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return ProjectResource
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $project = Project::where('requirement_id', Arr::get($request->validated(), 'requirement_id'))->first();

        if (!$project) {
            $project = Project::create($request->validated());
        }

        $project->services()->syncWithoutDetaching(Arr::pluck(Arr::get($request->validated(), 'services'), 'id'));

        $requirement = Requirement::findOrFail(Arr::get($request->validated(), 'requirement_id'));
        $requirement->project()->save($project);

        if (!$project->steps()->first()) {
            $step = Step::create([
                'name' => 'مرحله اول',
                'project_id' => $project->id,
                'send_sms' => 0,
                'template_id' => 0,
                'user_id' => Auth::id()
            ]);
            $step->project()->save($project);
        }

        $project->save();

        return new ProjectResource(
            $project->load(['services', 'requirement', 'step'])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project): ProjectResource
    {
        return new ProjectResource(
            $project->load([
                'services' => function ($query) {
                    return $query->with(['user', 'category', 'city.county.province']);
                },
                'requirement' => function ($query) {
                    return $query->with(['user', 'category', 'city.county.province']);
                },
                'step'
            ])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return ProjectResource
     */
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $project->fill($request->validated());

        if (Arr::get($request->validated(), 'services')) {
            $project->services()->syncWithoutDetaching(Arr::pluck(Arr::get($request->validated(), 'services'), 'id'));
        }

        $project->save();

        return new ProjectResource(
            $project->load(['services', 'requirement', 'step'])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project): \Illuminate\Http\Response
    {
        $project->delete();
        return response('ok');
    }
}
