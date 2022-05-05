<?php

namespace App\Services\Template;

use App\Exceptions\ErrorException;
use App\Jobs\SendSmsBatch;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Arr;

class ChangeStepTemplateManager
{
    private $template;
    private $userIds = [];
    private $project;
    private $messages = [];

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
        (new ChangeStepTemplateManager($project, $data))->build()->send();
    }

    private function build(): ChangeStepTemplateManager
    {
        if ($this->template && $this->userIds) {
            foreach ($this->userIds as $key => $user_ids) {
                foreach ($user_ids as $value) {
                    $this->setMessages(TemplateAdaptor::buildTemplate($this->template, [$key => $value])->fill($this->project), $key, $value);
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
