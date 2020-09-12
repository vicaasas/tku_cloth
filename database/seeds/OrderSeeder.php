<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'file_id' => 'FILE_A',
            'stu_id' => 2,
            'cloth' => 1,
            'accessory' => 5,
        ]);
        DB::table('orders')->insert([
            'file_id' => 'FILE_B',
            'stu_id' => 2,
            'cloth' => 2,
            'accessory' => 6,
        ]);
        DB::table('orders')->insert([
            'file_id' => 'FILE_C',
            'stu_id' => 2,
            'cloth' => 1,
            'accessory' => 5,
        ]);
    }
}