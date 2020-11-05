<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;
use DB;
class StudentHaveOrders extends Model
{
    protected $connection = 'sub_mysql';
    protected $appends = ['m_or_b'];
    protected $fillable = [
        'order_id', 'stu_id','return','has_paid','created_at'
    ];

    public function have_orders()
    {

        return $this->hasMany('App\SubModel\ViewOrder', 'order_id', 'order_id')->where('has_cancel',0)
        ->select(['student_id','class_id','class_name','student_name','order_id','type','cloth','size','accessory','color']);
    }
    public function this_cancels()
    {

        return $this->hasMany('App\SubModel\ViewOrder', 'order_id', 'order_id')->where('has_cancel',1)
        ->select(['student_id','class_id','class_name','student_name','order_id','type','cloth','size','accessory','color']);
    }
    public function get_counts()
    {
        return $this->hasMany('App\SubModel\ViewOrder', 'order_id', 'order_id')
        ->select('order_id',DB::raw('count(order_id) as total'))
        ->where('has_cancel',0)
        ->groupBy('order_id');

    }
    public function getMOrBAttribute()
    {
        $degree=substr($this->stu_id,0,1);
        if($degree == 4 || $degree == 2){
            return '學士';
        }
        else{
            return '碩士';
        }
        
    }
}
