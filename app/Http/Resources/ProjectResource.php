<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'service' => ServiceResource::collection($this->whenLoaded('services')),
            'requirement' => new RequirementResource($this->whenLoaded('requirement')),
            'step' => new StepResource($this->whenLoaded('step')),
        ];
    }
}
