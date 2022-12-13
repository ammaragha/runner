<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "id"=>$this->id,
            "description"=>$this->description,
            "voice"=>$this->voice,
            "date"=>$this->date,
            "time"=>$this->time,
            "urgent"=>$this->urgent,
            "complex"=>$this->complex,
            "care_for"=>$this->care_for,
            "response"=>$this->response,
            "status"=>$this->status,
            "deal"=>$this->deal,
            "properties"=>$this->properties,
            "user"=> new UserResource($this->user),
            "runner"=> new UserResource($this->runner),
            "address"=> new AddressResource($this->address)
        ];
    }
}
