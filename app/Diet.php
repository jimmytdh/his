<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $connection = 'mysql';
    protected $table = 'diet';
    protected $fillable = ['code','diet_code','ward_code','room_code','remarks','date_added'];
}
