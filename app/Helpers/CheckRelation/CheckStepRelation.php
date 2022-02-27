<?php

namespace App\Helpers\CheckRelation;

use App\Models\Project;
use App\Models\Step;

trait CheckStepRelation
{
    public function canDelete(Step $step): bool
    {
        if (Project::where('step_id', $step->id)->exists()) {
            return false;
        }
        return true;
    }
}
