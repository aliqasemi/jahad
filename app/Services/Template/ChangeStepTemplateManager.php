<?php

namespace App\Services\Template;

use App\Exceptions\ErrorException;
use App\Models\Project;
use Illuminate\Support\Arr;

class ChangeStepTemplateManager
{
    private $template;
    private $userIds = [];
    private $project;

    public function __construct(Project $project, array $data)
    {
        $this->project = $project;
        if (Arr::get($data, 'step_id') != $project->step_id) {
            $template = $project->steps()->where('id', Arr::get($data, 'step_id'))->first()->template()->first();
            $this->template = Arr::get($template, 'template');
            Arr::set($this->userIds, 'requirement', [$project->requirement()->first()->user_id]);
            Arr::set($this->userIds, 'services', $project->services()->pluck('user_id'));
        }
    }

    /**
     * @throws ErrorException
     */
    public static function buildToSend(Project $project, array $data)
    {
        (new ChangeStepTemplateManager($project, $data))->send();
    }

    /**
     * @throws ErrorException
     */
    private function send(): void
    {
        $message = [];
        if ($this->template && $this->userIds) {
            foreach ($this->userIds as $key => $user_ids) {
                foreach ($user_ids as $value) {
                    $message[$key][$value] = TemplateAdaptor::buildTemplate($this->template, [$key => $value])->fill($this->project);
                }
            }
            dd($message);
        } else {
            throw new ErrorException("don't have template or user ids");
        }

    }
}
