<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentOrders extends Model
{
    protected $fillable = [
        'order_id', 'stu_id'
    ];
}
