<?php
use App\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentHaveOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_have_orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('stu_id')->comment('使用者 ID');
            $table->foreign('stu_id')->references('student_id')->on('students');
            $table->tinyInteger('return')->default(0)->comment('是否歸還');
            //$table->tinyInteger('has_paid')->default(0)->comment('是否完成繳費');
            //$table->tinyInteger('has_guarantee_deposit_returned')->default(0)->comment('是否領回保證金');
            $table->integer('state')->default(Order::STATE_BORROW)->comment('狀態');

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
        Schema::dropIfExists('student_orders');
    }
}
