<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $connection = 'homis';
    protected $table = 'hward';
}
