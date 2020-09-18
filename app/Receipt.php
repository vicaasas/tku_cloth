<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'receipt_no','order_id', 'payer','pay_date'
    ];
}
