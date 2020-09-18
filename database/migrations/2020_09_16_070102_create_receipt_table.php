<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->string('receipt_no')->comment('繳費單號')->primary();
            $table->integer('order_id')->comment('訂單編號');

            $table->string('payer')->comment('繳費人');
            $table->string('role')->comment('身分別');
            
            $table->dateTime('pay_date')->comment('繳費時間');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt');
    }
}
