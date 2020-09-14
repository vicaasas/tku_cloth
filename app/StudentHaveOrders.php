<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHaveOrders extends Model
{
    protected $fillable = [
        'order_id', 'stu_id'
    ];

    public function have_orders()
    {
        return $this->hasMany('App\Order', 'order_id', 'order_id');
    }
}
