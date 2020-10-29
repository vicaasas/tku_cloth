<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GetTime extends Model
{
    public $table = "get_cloths_time";
    protected $fillable = [
        'id','degree', 'time'
    ];
}
