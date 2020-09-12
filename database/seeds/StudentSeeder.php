<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student')->insert([
            'student_id'=>'705060043',
            'class_id'=>'TABAJ2',
            'class_name'=>'資圖二數碩專',
            'student_name'=>'吳明仲',
            'passwd'=>'e39482f4d7d250175a4af2a6929fb94e',
            'semester'=>'2',
        ]);
        DB::table('student')->insert([
            'student_id'=>'706060075',
            'class_id'=>'TABAJ2',
            'class_name'=>'資圖二數碩專',
            'student_name'=>'翁靜婉',
            'passwd'=>'5153e5a0b2beeaacf5c2a9a89cb6729d',
            'semester'=>'2',
        ]);
        DB::table('student')->insert([
            'student_id'=>'406411255',
            'class_id'=>'aaaa',
            'class_name'=>'資工四B',
            'student_name'=>'周孝威',
            'passwd'=>'test',
            'semester'=>'2',
        ]);
    }
}
