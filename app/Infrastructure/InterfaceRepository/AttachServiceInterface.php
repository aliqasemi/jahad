<?php

namespace App\Infrastructure\InterfaceRepository;

interface AttachServiceInterface
{
    public function attachAllServices(): array;

    public function attachByService(int $requirementId): array;
}
