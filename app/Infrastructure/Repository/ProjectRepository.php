<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\InterfaceRepository\ProjectInterface;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Step;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectInterface
{
    public function index($data)
    {
        return Project::filter(request())->with(['services', 'requirement', 'step'])->paginate($data);
    }

    public function store(array $data)
    {
        $project = Project::where('requirement_id', Arr::get($data, 'requirement_id'))->first();

        if (!$project) {
            $project = Project::create($data);
        }

        $project->services()->syncWithoutDetaching(Arr::pluck(Arr::get($data, 'services'), 'id'));

        $requirement = Requirement::findOrFail(Arr::get($data, 'requirement_id'));
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

        if (Arr::has($data, 'require_products')) {
            foreach (Arr::get($data, 'require_products') as $require_product) {
                $project->requireProducts()->updateOrCreate(
                    ['id' => Arr::get($require_product, 'id')],
                    $require_product
                );
            }
        }

        $project->save();

        return $project->load(['services', 'requirement', 'step', 'requireProducts']);
    }

    public function show(int $projectId)
    {
        $project = Project::findOrFail($projectId);

        return $project->load([
            'services' => function ($query) {
                return $query->with(['user', 'category', 'city.county.province']);
            },
            'requirement' => function ($query) {
                return $query->with(['user', 'category', 'city.county.province']);
            },
            'step',
            'requireProducts'
        ]);
    }

    public function update(array $data, int $projectId)
    {
        $project = Project::findOrFail($projectId);

        $project->fill($data);

        if (Arr::get($data, 'services')) {
            $project->services()->syncWithoutDetaching(Arr::pluck(Arr::get($data, 'services'), 'id'));
        }

        if (Arr::has($data, 'require_products')) {
            foreach (Arr::get($data, 'require_products') as $require_product) {
                $project->requireProducts()->updateOrCreate(
                    ['id' => Arr::get($require_product, 'id')],
                    $require_product
                );
            }
        }

        $project->save();

        return $project->load(['services', 'requirement', 'step', 'requireProducts']);
    }

    public function delete(int $projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();
        return response('عملیات با موفقیت انجام شد');
    }
}
