<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "name" => $this->name,
            "lat" => $this->lat,
            "long" => $this->long,
            "city" => $this->city,
            "state" => $this->state,
            "street" => $this->street,
            "suite" => $this->suite,
            "zip" => $this->zip,
            "phone" => $this->phone
        ];
    }
}
