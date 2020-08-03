<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class PatRoom extends Model
{
    protected $connection = 'homis';
    protected $table = 'hpatroom';
}
