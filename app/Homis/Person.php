<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $connection = 'homis';
    protected $table = 'hperson';
}
