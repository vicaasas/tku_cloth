<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGetClothTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('get_cloths_time', function (Blueprint $table) {
            $table->increments('id')->nullable();
            $table->string('degree', 5)->comment('學位');
            $table->dateTime("start_time")->comment('衣物領取開始時間');
            $table->dateTime("end_time")->comment('衣物領取結束時間');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_cloth_time');
    }
}
