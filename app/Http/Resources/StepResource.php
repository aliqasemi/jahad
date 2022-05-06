<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StepResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'sort' => $this->sort,
            'send_sms' => $this->send_sms,
            'user' => new UserResource($this->whenLoaded('user')),
            'serviceTemplate' => new TemplateResource($this->whenLoaded('serviceTemplate')),
            'requirementTemplate' => new TemplateResource($this->whenLoaded('requirementTemplate')),
        ];
    }
}
