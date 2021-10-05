<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Models\User;

class UserResource extends Resource
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
            'created_at'=>$this->created_at,
            'status' => array_search($this->status, User::STATUS)
        ];
    }
}
