<?php

namespace App\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens, HasRoles, SoftDeletes;

    public const STATUS = ['pending' => 0, 'active' => 1, 'blocked' => 2];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public static function getPermissionNames($data): array
    {
        return $data->pluck('name')->toArray();
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public static function clean($value)
    {
        $value = strtolower($value);
        
        if (strpos($value, ',') !== false) {
            return explode(",", $value);
        }

        return $value;
    }

    public function scopeRoles($query, array $names)
    {
        return $query->whereHas('roles', function ($query) use ($names) {
            $query->whereIn('name', $names);
        });
    }
}
