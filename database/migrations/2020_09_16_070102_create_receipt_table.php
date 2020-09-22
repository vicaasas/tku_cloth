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
            $table->string('receipt_no')->default(null)->comment('繳費單號')->primary();
            $table->integer('order_id')->default(null)->comment('訂單編號');

            $table->string('payer')->default(null)->comment('繳費人');
                        
            $table->dateTime('receipt_date')->default(null)->comment('收據登記時間');

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
