<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'phone_number' => $this->phone_number,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
