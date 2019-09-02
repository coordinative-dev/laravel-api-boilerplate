<?php

namespace App\Modules\API\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDeviceResource extends JsonResource
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
            'device_id' => $this->device_id,
            'device_token' => $this->device_token,
        ];
    }
}
