<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'content', 'start_time', 'end_time'
    ];
}
