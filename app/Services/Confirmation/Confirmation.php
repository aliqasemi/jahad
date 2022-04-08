<?php

namespace App\Services\Confirmation;

use App\Jobs\SendSmsBatch;
use App\Models\Template;
use App\Models\User;
use App\Services\Template\TemplateAdaptor;
use Illuminate\Support\Facades\Cache;

class Confirmation
{
    private int $templateId;
    private string $type;
    private User $user;

    public function __construct(string $type, User $user, int $templateId)
    {
        $this->templateId = $templateId;
        $this->user = $user;
        $this->type = $type;
    }

    public static function build($type, User $user, $templateId)
    {
        (new Confirmation($type, $user, $templateId))->confirm();
    }

    /**
     * @param string $type
     */
    public function setType(int $templateId): void
    {
        $this->templateId = $templateId;
    }

    public function confirm()
    {
        $randNumber = rand(1000000, 9999999);
        Cache::put($this->type . $randNumber, $this->user->id, 1000);
        $template = Template::query()->findOrFail($this->templateId)->template;
        $message = TemplateAdaptor::buildTemplate($template, [])->setReplacementWithoutModel($randNumber)->fill($this->user);
        SendSmsBatch::dispatch($this->user, $message)->onConnection('confirm');
    }
}
