<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            [

                'name' => '田中太郎',
                'name_kana' => 'タナカタロウ',
                'email' => 'example@example.com',
                'email_verified_at' => null,
                'password' => 11111111,
                'profile_image' => 'profile1.png',
                'grade_id' => 1,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [

                'name' => '伊藤二郎',
                'name_kana' => 'イトウジロウ',
                'email' => 'example2@example.com',
                'email_verified_at' => null,
                'password' => 11111111,
                'profile_image' => 'profile2.png',
                'grade_id' => 7,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [

                'name' => '鈴木花子',
                'name_kana' => 'スズキハナコ',
                'email' => 'example3@example.com',
                'email_verified_at' => null,
                'password' => 11111111,
                'profile_image' => 'profile3.png',
                'grade_id' => 5,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [

                'name' => '河本佳奈',
                'name_kana' => 'コウモトカナ',
                'email' => 'example4@example.com',
                'email_verified_at' => null,
                'password' => 11111111,
                'profile_image' => 'profile4.png',
                'grade_id' => 12,
                'remember_token' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
