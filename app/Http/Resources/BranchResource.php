<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'cell_number' => $this->cell_number,
            'phone_number' => $this->phone_number,
            'city' => new CityResource($this->whenLoaded('city')),
            'main_image' => new MediaResource($this->whenLoaded('main_image')),
            'branch_product' => new BranchProductResource($this->whenLoaded('pivot')),
        ];
    }
}
