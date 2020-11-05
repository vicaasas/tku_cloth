<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'sub_mysql';
    protected $fillable = [
        'key', 'value',
    ];
}
