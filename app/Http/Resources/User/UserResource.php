<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Address\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "role" => $this->role,
            "name" => $this->name,
            "phone" => $this->phone,
            "gender" => $this->gender,
            "email" => $this->email,
            "runner" => new RunnerResource($this->runner),
            "addresses" => AddressResource::collection($this->addresses),
        ];
    }
}
