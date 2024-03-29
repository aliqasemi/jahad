<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequireProductResource extends JsonResource
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
            'number' => $this->number,
            'product_require_product' => ProductRequireProductResource::collection($this->whenLoaded('productRequireProduct')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'project' => new ProjectResource($this->whenLoaded('project')),
        ];
    }
}
