<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachServiceResource;
use App\Infrastructure\InterfaceRepository\AttachServiceInterface;
use App\Models\Service;
use App\Models\User;

class AttachServiceRequirement extends Controller
{
    public function __invoke()
    {
        $this->authorize('view', User::class);

        return app()->make(AttachServiceInterface::class)->attachAllServices();
    }

    public function indexAttach(Service $service)
    {
        $this->authorize('view', User::class);

        return AttachServiceResource::collection(
            app()->make(AttachServiceInterface::class)->attachByService($service->id)
        );
    }
}
