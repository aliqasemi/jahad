<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Infrastructure\InterfaceRepository\ProjectInterface;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Project::class);

        return ProjectResource::collection(
            app()->make(ProjectInterface::class)->index(['per_page' => request('per_page'), 'page' => request('page')])
        );
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexFilter(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $this->authorize('view', Project::class);

        return ProjectResource::collection(
            Project::filter(request())->with(['services', 'requirement'])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @return ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $this->authorize('create', Project::class);

        return new ProjectResource(
            app()->make(ProjectInterface::class)->store($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project): ProjectResource
    {
        $this->authorize('view', Project::class);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $this->authorize('update', Project::class);

        return new ProjectResource(
            app()->make(ProjectInterface::class)->update($request->validated(), $project->id)
        );
    }

    /**
     * change step the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changeStep(Request $request, Project $project): ProjectResource
    {
        $this->authorize('update', Project::class);

        $request->validate([
            'step_id' => 'required|integer'
        ]);

        return new ProjectResource(
            app()->make(ProjectInterface::class)->changeStep($request->only('step_id'), $project->id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project): \Illuminate\Http\Response
    {
        $this->authorize('delete', Project::class);

        return app()->make(ProjectInterface::class)->delete($project->id);
    }
}
