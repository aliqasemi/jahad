<?php

namespace App\Observers;

use App\Http\Services\CacheManagement;
use App\Models\Requirement;

class RequirementObserver
{
    /**
     * Handle the Category "saving" event.
     *
     * @param \App\Models\Requirement $requirement
     * @return void
     */
    public function saving(Requirement $requirement)
    {
        CacheManagement::popItems($requirement, $requirement->id);
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param \App\Models\Requirement $requirement
     * @return void
     */
    public function deleted(Requirement $requirement)
    {
        CacheManagement::popItems($requirement, $requirement->id);
    }
}
