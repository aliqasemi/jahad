<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requirement\StoreRequirementRequest;
use App\Http\Requests\Requirement\UpdateRequirementRequest;
use App\Http\Resources\RequirementResource;
use App\Models\Requirement;
use App\Models\User;
use App\Services\CacheManagement\CacheManagement;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('viewAny', Requirement::class);

//        return RequirementResource::collection(
//            CacheManagement::buildList(Requirement::getModel(), ['main_image', 'city.county.province', 'user', 'category'], [], ['per_page' => request('per_page'), 'page' => request('page')])
//        );

        return RequirementResource::collection(
            Requirement::query()->filter(request())->with(['main_image', 'city.county.province', 'user', 'category'])->paginate(request('per_page'), ['*'], 'page', request('page'))
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequirementRequest $request
     * @return RequirementResource
     */
    public function store(StoreRequirementRequest $request): RequirementResource
    {
        $this->authorize('create', Requirement::class);

        $user = User::findOrFail(Auth::id());
        $requirement = new Requirement($request->all());
        $user->requirements()->save($requirement);
        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $requirement->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $requirement->save();

        return new RequirementResource($requirement->load(['main_image', 'city.county.province', 'user', 'category']));
    }

    /**
     * Display the specified resource.
     *
     * @param Requirement $requirement
     * @return RequirementResource
     */
    public function show(Requirement $requirement): RequirementResource
    {
        $this->authorize('view', $requirement);

        return new RequirementResource(
            CacheManagement::buildItem(Requirement::getModel(), $requirement->id, ['main_image', 'category', 'city.county.province', 'user', 'project.services'], [])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequirementRequest $request
     * @param Requirement $requirement
     * @return RequirementResource
     */
    public function update(UpdateRequirementRequest $request, Requirement $requirement): RequirementResource
    {
        $this->authorize('update', $requirement);

        $requirement->fill($request->all());

        if (!is_null(Arr::get($request->all(), 'main_image'))) {
            $requirement->main_image()->delete();
            $requirement->addMedia(Arr::get($request->all(), 'main_image'))->toMediaCollection('main_image');
        }

        $requirement->save();

        return new RequirementResource($requirement->load(['main_image', 'category', 'city.county.province', 'user']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Requirement $requirement
     * @return Response
     */
    public function destroy(Requirement $requirement): Response
    {
        $this->authorize('delete', $requirement);

        $requirement->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
