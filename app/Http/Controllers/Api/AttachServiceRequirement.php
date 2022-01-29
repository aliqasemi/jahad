<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachServiceResource;
use App\Infrastructure\InterfaceRepository\AttachServiceInterface;
use App\Models\Service;

class AttachServiceRequirement extends Controller
{
    public function __invoke()
    {
        return app()->make(AttachServiceInterface::class)->attachAllServices();
    }

    public function indexAttach(Service $service)
    {
        return AttachServiceResource::collection(
            app()->make(AttachServiceInterface::class)->attachByService($service->id)
        );
    }
}
