<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttachRequirementResource;
use App\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Models\Requirement;

class AttachRequirementService extends Controller
{
    public function __invoke()
    {
        return app()->make(AttachRequirementInterface::class)->attachAllRequirements();
    }

    public function indexAttach(Requirement $requirement)
    {
        return AttachRequirementResource::collection(
            app()->make(AttachRequirementInterface::class)->attachByRequirement($requirement->id)
        );
    }
}
