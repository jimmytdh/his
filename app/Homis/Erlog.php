<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Erlog extends Model
{
    protected $connection = 'homis';
    protected $table = 'herlog';
}
