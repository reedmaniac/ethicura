<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CorporationProductResource extends JsonResource
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
            'certifications' => $this->certifications
                ->sortBy('name')
                ->values()
                ->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name])
                ->toArray(),
            'packaging' => $this->packaging
                ->sortBy('name')
                ->values()
                ->map(fn ($tag) => ['id' => $tag->id, 'name' => $tag->name])
                ->toArray(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
