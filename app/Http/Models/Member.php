<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UserAuditTrait;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Member extends Model
{
    use UserAuditTrait, CascadeSoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
