<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHaveOrders extends Model
{
    protected $fillable = [
        'order_id', 'stu_id','return','has_paid'
    ];

    public function have_orders()
    {
        return $this->hasMany('App\ViewOrder', 'order_id', 'order_id');
    }
}
