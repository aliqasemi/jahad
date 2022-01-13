<?php

namespace App\Observers;

use App\Http\Services\CacheManagement;
use App\Models\Service;

class ServiceObserver
{
    /**
     * Handle the Category "saving" event.
     *
     * @param \App\Models\Service $service
     * @return void
     */
    public function saving(Service $service)
    {
        CacheManagement::popItems($service, $service->id);
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param \App\Models\Service $service
     * @return void
     */
    public function deleted(Service $service)
    {
        CacheManagement::popItems($service, $service->id);
    }
}
