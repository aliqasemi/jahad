<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'stock_sum' => $this->branches_sum_branch_productstock,
            'main_image' => new MediaResource($this->whenLoaded('main_image')),
            'branches' => BranchResource::collection($this->whenLoaded('branches')),
            'product_require_product' => new ProductRequireProductResource($this->whenLoaded('pivot')),
        ];
    }
}
