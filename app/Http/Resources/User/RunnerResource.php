<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Service\ServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RunnerResource extends JsonResource
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
            "cost_per_hour" => $this->cost_per_hour,
            "is_active"=> $this->is_active,
            "service" => new ServiceResource($this->service),
        ];
    }
}
