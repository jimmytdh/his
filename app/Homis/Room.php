<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $connection = 'homis';
    protected $table = 'hroom';
}
