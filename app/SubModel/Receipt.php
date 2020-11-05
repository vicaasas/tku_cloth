<?php

namespace App\SubModel;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $connection = 'sub_mysql';
    protected $table = 'receipts';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'receipt_no','order_id', 'payer','receipt_date'
    ];
}
