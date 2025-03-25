<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('articles')->insert([
            [
                'title' => 'タイトル1',
                'posted_date' => date('Y-m-d H:i:s'),
                'article_contents' => '本文はこちら本文はこちら本文はこちら本文はこちら本文はこちら',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'タイトル2',
                'posted_date' => date('Y-m-d H:i:s'),
                'article_contents' => '本文はこちら本文はこちら本文はこちら本文はこちら本文はこちら',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'タイトル3',
                'posted_date' => date('Y-m-d H:i:s'),
                'article_contents' => '本文はこちら本文はこちら本文はこちら本文はこちら本文はこちら',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'タイトル4',
                'posted_date' => date('Y-m-d H:i:s'),
                'article_contents' => '本文はこちら本文はこちら本文はこちら本文はこちら本文はこちら',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'タイトル5',
                'posted_date' => date('Y-m-d H:i:s'),
                'article_contents' => '本文はこちら本文はこちら本文はこちら本文はこちら本文はこちら',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
