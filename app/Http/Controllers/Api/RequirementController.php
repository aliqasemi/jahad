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
        return RequirementResource::collection(
            CacheManagement::buildList(Requirement::getModel(), ['main_image', 'city.county.province', 'user', 'category'], [], request('page'))
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
        $requirement->fill($request->all());
        $requirement->main_image()->delete();
        if (!is_null(Arr::get($request->all(), 'main_image'))) {
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
        $requirement->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
