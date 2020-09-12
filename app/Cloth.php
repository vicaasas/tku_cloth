<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cloth extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //public $table = "cloths";
    protected $fillable = [
        'id','type', 'name', 'property', 'quantity'
    ];
    public function order_number(){
        return $this->belongsTo('App\Order');
    }
}
