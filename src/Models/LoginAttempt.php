<?php

namespace Chimp\LoginAttempts\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event', 'user_id', 'email', 'ip',
    ];
}
