<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'sub_mysql';
    public $timestamps = false;
    protected $fillable = [
        'content', 'start_time', 'end_time'
    ];
}
