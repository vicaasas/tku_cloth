<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 預設時間段插入
         *
         */
        DB::table('times')->insert([
            'content' => '借用時間',
            'start_time' => date("Y-m-d H:i H:i"),
            'end_time' => date("Y-m-d H:i"),
        ]);
        DB::table('times')->insert([
            'content' => '收據列印時間',
            'start_time' => date("Y-m-d H:i"),
            'end_time' => date("Y-m-d H:i"),
        ]);
        DB::table('times')->insert([
            'content' => '繳費期限',
            'start_time' => date("Y-m-d H:i"),
            'end_time' => date("Y-m-d H:i"),
        ]);
        DB::table('times')->insert([
            'content' => '歸還期限',
            'start_time' => date("Y-m-d H:i"),
            'end_time' => date("Y-m-d H:i"),
        ]);
        DB::table('get_cloths_time')->insert([
            'degree' => '學士',
            'time' => date("Y-m-d H:i"),
        ]);
        DB::table('get_cloths_time')->insert([
            'degree' => '學士',
            'time' => date("Y-m-d H:i"),
        ]);
        DB::table('get_cloths_time')->insert([
            'degree' => '碩士',
            'time' => date("Y-m-d H:i"),
        ]);
        DB::table('get_cloths_time')->insert([
            'degree' => '碩士',
            'time' => date("Y-m-d H:i"),
        ]);
    }
}