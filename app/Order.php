<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATE_BORROW = 0;
    const STATE_PAID = 1;
    const STATE_MONEY_BACK = 2;
    const STATE_RETURNED = 3;
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', 'stu_id', 'class_id', 'cloth', 'accessory',
    ];

    public function cloth()
    {
        return $this->hasOne('App\Cloth', 'id', 'cloth');
    }

    public function accessory()
    {
        return $this->hasOne('App\Cloth', 'id', 'accessory');
    }

    public function student()
    {
        return $this->belongsTo('App\Student', 'stu_id', 'student_id');
    }
    
    public function class_total()
    {
        return $this->belongsTo('App\Student', 'stu_id', 'student_id')->groupBy('class_name');
    }
}