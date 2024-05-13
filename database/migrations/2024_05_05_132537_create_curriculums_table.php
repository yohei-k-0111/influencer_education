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
        Schema::create('curriculums', function (Blueprint $table) {

            $table->increments('id'); // int(10) のid
            $table->string('title'); // varchar(255) のカリキュラムタイトル notnull
            $table->string('thumbnail')->nullable(); // varchar(255) のサムネイル画像タイトル ※nullable
            $table->longText('description')->nullable(); // longtext のカリキュラム説明文 ※nullable
            $table->mediumText('video_url')->nullable(); // mediumtext の動画URL ※nullable
            $table->tinyInteger('always_delivery_flg'); // tinyint(4)  0:OFF, 1:ON /ONで動画常時公開
            $table->unsignedInteger('grade_id'); // 符号なしint(10) の学年id notnull
            $table->timestamps(); // 作成日時created_at と 更新日時updated_at のtimestamp

            // 外部キー制約を追加
            $table->foreign('grade_id')
                  ->references('id')
                  ->on('grades')
                  ->cascadeOnDelete()  // ON DELETE で CASCADE
                  ->cascadeOnUpdate(); // ON UPDATE で CASCADE

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculums');
    }
};