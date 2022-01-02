<?php

namespace App\Http\Infrastructure\InterfaceRepository;

interface AttachServiceInterface
{
    public function attachAllServices(): array;

    public function attachByService(int $requirementId): array;
}
