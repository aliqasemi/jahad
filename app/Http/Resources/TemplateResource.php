<?php

namespace App\Http\Resources;

use App\Models\Template;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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
            'template' => $this->template,
            'can_delete' => !in_array($this->id, Template::getDefaultTemplateIds()),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
