<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\BaseResponse;
use Illuminate\Http\Resources\Json\Resource;

class MembersResponse extends BaseResponse
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->wrapped(['members' => UserResource::collection($this)]);
    }
}
