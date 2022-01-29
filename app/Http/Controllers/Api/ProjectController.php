<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Service;
use App\Models\Step;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::with(['service', 'requirement', 'step'])->paginate(request('per_page'))
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

        $project = Project::create($request->validated());

        $service = Service::findOrFail(Arr::get($request->validated(), 'service_id'));
        $service->projects()->save($project);

        $requirement = Requirement::findOrFail(Arr::get($request->validated(), 'requirement_id'));
        $requirement->projects()->save($project);

        $step = Step::first();

        $step->projects()->save($project);

        $project->save();

        return new ProjectResource(
            $project->load(['service', 'requirement', 'step'])
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
                'service' => function ($query) {
                    return $query->with(['user', 'category']);
                },
                'requirement' => function ($query) {
                    return $query->with(['user', 'category']);
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

        $project->save();

        return new ProjectResource(
            $project->load(['service', 'requirement', 'step'])
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
