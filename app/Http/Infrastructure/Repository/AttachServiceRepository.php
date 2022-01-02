<?php

namespace App\Http\Infrastructure\Repository;

use App\Http\Infrastructure\InterfaceRepository\AttachServiceInterface;
use App\Http\Services\AttachServiceRequirement;
use App\Models\Service;

class AttachServiceRepository implements AttachServiceInterface
{
    public function attachAllServices(): array
    {
        $services = Service::get();
        $attachment = [];
        foreach ($services as $service) {
            $attachment[] = AttachServiceRequirement::build($service);
        }
        return $attachment;
    }

    public function attachByService(int $requirementId): array
    {
        $service = Service::findOrFail($requirementId);

        return AttachServiceRequirement::build($service);
    }
}
