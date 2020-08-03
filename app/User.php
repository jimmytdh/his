<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $fillable = [
        'fname',
        'lname',
        'pos_code',
        'dept_code',
        'section',
        'username',
        'password',
        'level',
        'status'
    ];
}
