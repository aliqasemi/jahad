<?php

namespace App\Services\Template;

use App\Exceptions\ErrorException;
use App\Jobs\SendSmsBatch;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Arr;

class ChangeStepTemplateManager
{
    private $serviceTemplate;
    private $requirementTemplate;
    private $userIds = [];
    private $project;
    private $messages = [];

    public function __construct(Project $project, array $data)
    {
        $this->project = $project;
        if (Arr::get($data, 'step_id') != $project->step_id) {
            $serviceTemplate = $project->steps()->where('id', Arr::get($data, 'step_id'))->first()->serviceTemplate()->first();
            $requirementTemplate = $project->steps()->where('id', Arr::get($data, 'step_id'))->first()->requirementTemplate()->first();
            $this->serviceTemplate = Arr::get($serviceTemplate, 'template');
            $this->requirementTemplate = Arr::get($requirementTemplate, 'template');
            Arr::set($this->userIds, 'requirement', [$project->requirement()->first()->user_id]);
            Arr::set($this->userIds, 'services', $project->services()->pluck('user_id'));
        }
    }

    /**
     * @throws ErrorException
     */
    public static function buildToSend(Project $project, array $data)
    {
        (new ChangeStepTemplateManager($project, $data))->build()->send();
    }

    private function build(): ChangeStepTemplateManager
    {
        if ($this->requirementTemplate && $this->serviceTemplate && $this->userIds) {
            foreach ($this->userIds as $key => $user_ids) {
                foreach ($user_ids as $value) {
                    if ($key == 'requirement') {
                        $this->setMessages(TemplateAdaptor::buildTemplate($this->requirementTemplate, [$key => $value])->fill($this->project), $key, $value);
                    } else if ($key == 'services') {
                        $this->setMessages(TemplateAdaptor::buildTemplate($this->serviceTemplate, [$key => $value])->fill($this->project), $key, $value);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * @throws ErrorException
     */
    private function send()
    {
        foreach ($this->messages as $group) {
            foreach ($group as $userId => $message) {
                SendSmsBatch::dispatch(User::query()->findOrFail($userId), $message);
            }
        }
    }

    /**
     * @param array $messages
     */
    private function setMessages(string $message, $key, $value): void
    {
        $this->messages[$key][$value] = $message;
    }
}
