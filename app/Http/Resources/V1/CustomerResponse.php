<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\BaseResponse;

class CustomerResponse extends BaseResponse
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->wrapped([
            'customer' => new UserResource($this)
        ]);
    }
}
