<?php

use App\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->increments('id');
            
            $table->string('order_id')->default(null)->nullable()->comment('訂單編號');
            $table->foreign('order_id')->references('order_id')->on('student_have_orders')->onDelete("cascade");

            $table->integer('stu_id')->comment('使用者 ID');
            $table->foreign('stu_id')->references('student_id')->on('students')->onDelete("cascade");

            $table->bigInteger('cloth')->unsigned()->comment('衣物 ID');
            $table->foreign('cloth')->references('id')->on('cloths');

            $table->bigInteger('accessory')->unsigned()->comment('配件 ID');
            $table->foreign('accessory')->references('id')->on('cloths');
            $table->tinyInteger('return')->default(0)->comment('是否歸還');
            $table->tinyInteger('has_cancel')->default(0)->comment('是否取消');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}