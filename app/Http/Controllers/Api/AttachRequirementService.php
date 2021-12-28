<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Infrastructure\InterfaceRepository\AttachRequirementInterface;

class AttachRequirementService extends Controller
{
    public function __invoke()
    {
        app()->make(AttachRequirementInterface::class)->attach();
    }
}
