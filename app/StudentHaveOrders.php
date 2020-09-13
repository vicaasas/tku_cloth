<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHaveOrders extends Model
{
    protected $fillable = [
        'order_id', 'stu_id'
    ];
}
