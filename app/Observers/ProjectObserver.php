<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\CacheManagement\CacheManagement;

class ProjectObserver
{
    /**
     * Handle the Category "saving" event.
     *
     * @param \App\Models\Project $requirement
     * @return void
     */
    public function saving(Project $project)
    {
        if ($project->requirement) {
            CacheManagement::popItems($project->requirement, $project->requirement->id);
        }
    }
}
