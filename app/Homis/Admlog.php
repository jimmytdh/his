<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Admlog extends Model
{
    protected $connection = 'homis';
    protected $table = 'hadmlog';
}
