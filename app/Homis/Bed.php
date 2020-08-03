<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $connection = 'homis';
    protected $table = 'hbed';
}
