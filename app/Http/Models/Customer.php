<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public const STATUS = ['pending' => 0, 'active' => 1];
}
