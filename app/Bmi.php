<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bmi extends Model
{
    protected $connection = 'mysql';
    protected $table = 'bmi';
    protected $fillable = ['code','weight','height'];
}
