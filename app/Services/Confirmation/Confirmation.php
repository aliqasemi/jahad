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
    private bool $isCache;

    public function __construct(string $type, User $user, int $templateId, bool $isCache)
    {
        $this->templateId = $templateId;
        $this->user = $user;
        $this->type = $type;
        $this->isCache = $isCache;
    }

    public static function build($type, User $user, $templateId, $isCache = true)
    {
        (new Confirmation($type, $user, $templateId, $isCache))->confirm();
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
        if ($this->isCache) {
            Cache::put($this->type . $randNumber, $this->user->id, 1000);
        }
        $template = Template::query()->findOrFail($this->templateId)->template;
        $message = TemplateAdaptor::buildTemplate($template, [])->setReplacementWithoutModel($randNumber)->fill($this->user);
        SendSmsBatch::dispatch($this->user, $message)->onConnection('confirm');
    }
}
