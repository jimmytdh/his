<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $connection = 'homis';
    protected $table = 'hpersonal';
}
