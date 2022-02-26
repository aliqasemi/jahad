<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Infrastructure\InterfaceRepository\ProjectInterface;
use App\Models\Project;
use Illuminate\Support\Arr;

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
            app()->make(ProjectInterface::class)->index(request('per_page'))
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
        return new ProjectResource(
            app()->make(ProjectInterface::class)->store($request->validated())
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
            app()->make(ProjectInterface::class)->show($project->id)
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
        return new ProjectResource(
            app()->make(ProjectInterface::class)->update($request->validated(), $project->id)
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
        return app()->make(ProjectInterface::class)->delete($project->id);
    }
}
