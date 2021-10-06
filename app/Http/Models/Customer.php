<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UserAuditTrait;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Customer extends Model
{
    use UserAuditTrait,CascadeSoftDeletes;

    public const SEARCHABLE = ['name','email'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
