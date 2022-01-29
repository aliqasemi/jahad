<?php

namespace App\Infrastructure\InterfaceRepository;

interface AttachRequirementInterface
{
    public function attachAllRequirements(): array;

    public function attachByRequirement(int $requirementId): array;
}
