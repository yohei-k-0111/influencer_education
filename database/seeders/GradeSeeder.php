<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('grades')->insert([
            [
                'name' => '小学校1年生',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => '小学校2年生',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'name' => '小学校3年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '小学校4年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '小学校5年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '小学校6年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '中学校1年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '中学校2年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '中学校3年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '高校1年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '高校2年生',
                'created_at' => null,
                'updated_at' => null,
            ],[
                'name' => '高校3年生',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
