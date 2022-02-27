<?php

namespace App\Helpers\CheckRelation;

use App\Models\Template;

trait CheckTemplateRelation
{
    public function canDelete(Template $template): bool
    {
        if (in_array($template->id, Template::getDefaultTemplateIds())) {
            return false;
        }
        return true;
    }
}
