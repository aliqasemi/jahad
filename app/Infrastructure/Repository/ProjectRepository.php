<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\InterfaceRepository\ProjectInterface;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Step;
use App\Services\Template\ChangeStepTemplateManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements ProjectInterface
{
    public function index($data)
    {
        return Project::filter(request())->with(['services', 'requirement', 'step'])->paginate(Arr::get($data, 'per_page'), ['*'], 'page', Arr::get($data, 'page'));
    }

    public function indexUser($data, int $user_id)
    {
        return Project::query()
            ->whereHas('services', function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->orWhereHas('requirement', function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->with(['services', 'requirement', 'step'])
            ->filter(request())
            ->paginate(Arr::get($data, 'per_page'), ['*'], 'page', Arr::get($data, 'page'));
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
                'template_id' => null,
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
                return $query->with(['user', 'category', 'city.county.province', 'main_image']);
            },
            'requirement' => function ($query) {
                return $query->with(['user', 'category', 'city.county.province', 'main_image']);
            },
            'step',
            'requireProducts'
        ]);
    }

    public function showUser(int $projectId)
    {
        $project = Project::findOrFail($projectId);

        return $project->load([
            'services' => function ($query) {
                return $query->with(['user', 'category', 'city.county.province', 'main_image']);
            },
            'requirement' => function ($query) {
                return $query->with(['user', 'category', 'city.county.province', 'main_image']);
            },
            'step'
        ]);
    }

    /**
     * @throws \App\Exceptions\ErrorException
     */
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

    public function changeStep(array $data, int $projectId)
    {
        $project = Project::query()->findOrFail($projectId);

        if (Step::query()->findOrFail(Arr::get($data, 'step_id'))->send_sms)
            ChangeStepTemplateManager::buildToSend($project, $data);

        $project = Project::query()->findOrFail($projectId);
        $project->update(['step_id' => Arr::get($data, 'step_id')]);

        return $project->load(['services', 'requirement', 'step', 'requireProducts']);
    }

    public function delete(int $projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();
        return response(trans('messages.success_operation'));
    }
}
