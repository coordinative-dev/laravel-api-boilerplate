<?php

namespace App\Modules\API\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'categories' => CategoryResource::collection($this->categories),
            'images' => MediaResource::collection($this->media),
            'user' => new UserResource($this->user),
            'status' => $this->status,
            'booking_status' => $this->booking_status,
            'booked_by' => $this->bookedBy(),
            'created_at' => $this->created_at,
            'is_favorited' => $this->is_favorited ?? $this->isFavorited(auth('api')->user()->id),
        ];
    }
}
