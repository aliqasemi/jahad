<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Models\Requirement;
use App\Services\Attachment\AttachRequirementService;

class AttachRequirementRepository implements AttachRequirementInterface
{
    public function attachAllRequirements(): array
    {
        $requirements = Requirement::get();
        $attachment = [];
        foreach ($requirements as $requirement) {
            $attachment[] = AttachRequirementService::build($requirement);
        }
        return $attachment;
    }

    public function attachByRequirement(int $requirementId): array
    {
        $requirement = Requirement::findOrFail($requirementId);

        return AttachRequirementService::build($requirement);
    }
}
