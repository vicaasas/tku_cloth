<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class StudentHaveOrders extends Model
{
    protected $appends = ['m_or_b'];
    protected $fillable = [
        'order_id', 'stu_id','return','has_paid','created_at'
    ];

    public function have_orders()
    {

        return $this->hasMany('App\ViewOrder', 'order_id', 'order_id')->where('has_cancel',0);
    }
    public function this_cancels()
    {

        return $this->hasMany('App\ViewOrder', 'order_id', 'order_id')->where('has_cancel',1);
    }
    public function get_counts()
    {
        return $this->hasMany('App\ViewOrder', 'order_id', 'order_id')
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
