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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); // int(10) id
            $table->string('name'); // varchar(255) ユーザーネーム
            $table->string('name_kana'); // varchar(255) ユーザーネーム カナ
            $table->string('email')->unique(); // varchar(255) メールアドレス
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // varchar(255) パスワード
            $table->string('profile_image')->nullable(); // varchar(255) プロフィール画像
            $table->unsignedInteger('grade_id'); // 符号なしint(10) 学年id
            $table->rememberToken();
            $table->timestamps();

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
        Schema::dropIfExists('users');
    }
};
