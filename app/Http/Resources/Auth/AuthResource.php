<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            "token" => $this->token,
            "role" => $this->role,
            "name" => $this->name,
            "phone" => $this->phone,
            "gender" => $this->gender,
            "email" => $this->email
        ];
    }
}
