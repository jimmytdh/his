<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $connection = 'calendar';
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'color',
        'repeat_every',
        'type',
        'username'
    ];
}
