<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;

class Cloth extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'sub_mysql';
    protected $fillable = [
        'id','type', 'name', 'property', 'quantity'
    ];
    public function order_number(){
        return $this->belongsTo('App\SubModel\Order');
    }
}
