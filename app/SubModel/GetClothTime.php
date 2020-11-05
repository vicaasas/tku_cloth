<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;

class GetClothTime extends Model
{
    protected $connection = 'sub_mysql';
    public $table = "get_cloths_time";
    protected $fillable = [
        'id','degree', 'time'
    ];
}
