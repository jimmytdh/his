<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $connection = 'homis';
    protected $table = 'disposition';
}
