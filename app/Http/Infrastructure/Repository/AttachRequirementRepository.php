<?php

namespace App\Http\Infrastructure\Repository;

use App\Http\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Http\Services\AttachRequirementService;
use App\Models\Category;
use App\Models\Requirement;
use Illuminate\Support\Arr;

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
