<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {

            $table->increments('id'); // int(10) のid
            $table->string('title'); // varchar(255) お知らせタイトル
            $table->dateTime('posted_date'); // datetime(YYYYMMDDhhmmss) お知らせ投稿日時
            $table->longText('article_contents'); // longtext お知らせ本文 
            $table->timestamps(); // 作成日時created_at と 更新日時updated_at のtimestamp

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
