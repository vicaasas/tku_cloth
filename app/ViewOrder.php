<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewOrder extends Model
{
    protected $table = 'student_order';
    protected $fillable = [
        'student_id', 'class_id', 'class_name', 'student_name','order_id','type','cloth','size','accessory','color','return','has_paid'
    ];

}
