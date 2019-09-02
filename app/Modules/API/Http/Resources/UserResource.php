<?php

namespace App\Modules\API\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'image' => optional($this->getFirstMedia('avatar'))->getFullUrl('thumb'),
            'created_at' => $this->created_at,
        ];
    }
}
