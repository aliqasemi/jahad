<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequireProductResource extends JsonResource
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
            'number' => $this->number,
            'description' => $this->description,
            'total_number' => $this->total_number,
            'product' => new ProductResource($this->whenLoaded('product')),
            'branch' => new BranchResource($this->whenLoaded('branch'))
        ];
    }
}
