<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'sub_mysql';
    const STATE_BORROW = 0;
    const STATE_PAID = 1;
    const STATE_MONEY_BACK = 2;
    const STATE_RETURNED = 3;
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', 'stu_id', 'class_id', 'cloth', 'accessory','has_cancel'
    ];

    public function cloth()
    {
        return $this->hasOne('App\SubModel\Cloth', 'id', 'cloth');
    }

    public function accessory()
    {
        return $this->hasOne('App\SubModel\Cloth', 'id', 'accessory');
    }

    public function student()
    {
        return $this->belongsTo('App\SubModel\Student', 'stu_id', 'student_id');
    }
    
    public function class_total()
    {
        return $this->belongsTo('App\SubModel\Student', 'stu_id', 'student_id')->groupBy('class_name');
    }
}