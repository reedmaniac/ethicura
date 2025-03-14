<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'status' => $this->status,
            'corporation' => new CorporationResource($this->corporation),
            'certifications' => $this->certifications->sortBy('name')->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name]),
            'packaging' => $this->packaging->sortBy('name')->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name]),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
