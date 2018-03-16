<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'balance',
        'balance_hold',
        'external_id'
    ];

    /**
     * @param int $cost
     * @return bool
     */
    public function canDoOperation($cost = 0)
    {
        return ($this->balance - abs($cost)) >= 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
