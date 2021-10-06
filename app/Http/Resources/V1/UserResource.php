<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Models\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'country' => $this->country,
            'created_at'=>$this->created_at,
            'status' => array_search($this->status, User::STATUS),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
