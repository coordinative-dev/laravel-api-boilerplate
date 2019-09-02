<?php

namespace App\Modules\API\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'categories' => CategoryResource::collection($this->categories),
            'images' => MediaResource::collection($this->media),
        ];
    }
}
