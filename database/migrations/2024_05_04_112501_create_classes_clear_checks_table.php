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
        Schema::create('classes_clear_checks', function (Blueprint $table) {
            $table->increments('id'); // int(10) のid
            $table->unsignedInteger('users_id'); // 符号なしint(10) のユーザーid notnull
            $table->unsignedInteger('grade_id'); // 符号なしint(10) の学年id notnull
            $table->tinyInteger('clear_flg'); // tinyint(4) 1:クリア、0:未クリア
            // curriculumsテーブルにある同一クラスIDのカリキュラムがすべてcurriculum_progressテーブルにてclear_flg =1になった際、このカラムも1にする。
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('users_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete()  // ON DELETE で CASCADE
                  ->cascadeOnUpdate(); // ON UPDATE で CASCADE

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
        Schema::dropIfExists('classes_clear_checks');
    }
};
