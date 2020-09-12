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
            'start_time' => date("Y-m-d"),
            'end_time' => date("Y-m-d"),
        ]);
        DB::table('times')->insert([
            'content' => '收據列印時間',
            'start_time' => date("Y-m-d"),
            'end_time' => date("Y-m-d"),
        ]);
        DB::table('times')->insert([
            'content' => '繳費期限',
            'start_time' => date("Y-m-d"),
            'end_time' => date("Y-m-d"),
        ]);
        DB::table('times')->insert([
            'content' => '歸還期限',
            'start_time' => date("Y-m-d"),
            'end_time' => date("Y-m-d"),
        ]);
        DB::table('times')->insert([
            'content' => '領取時間(學士服)',
            'start_time' => date("Y-m-d"),
            'end_time' => date("Y-m-d"),
        ]);
        DB::table('times')->insert([
            'content' => '領取時間(碩士服)',
            'start_time' => date("Y-m-d"),
            'end_time' => date("Y-m-d"),
        ]);
    }
}