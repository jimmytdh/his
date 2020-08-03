<?php

namespace App\Homis;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $connection = 'homis';
    protected $table = 'hdiag';
}
