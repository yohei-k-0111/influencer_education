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
        Schema::create('curriculum_progress', function (Blueprint $table) {
            $table->increments('id'); // int(10) のid
            $table->unsignedInteger('curriculums_id'); // 符号なしint(10) のカリキュラムid notnull
            $table->unsignedInteger('users_id'); // 符号なしint(10) のユーザーid notnull
            $table->tinyInteger('clear_flg'); // tinyint(4) 1:クリア、0:未クリア
            $table->timestamps(); // 作成日時created_at と 更新日時updated_at のtimestamp

            // 外部キー制約を追加
            $table->foreign('curriculums_id')
                  ->references('id')
                  ->on('curriculums')
                  ->cascadeOnDelete()  // ON DELETE で CASCADE
                  ->cascadeOnUpdate(); // ON UPDATE で CASCADE

            $table->foreign('users_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('curriculum_progress');
    }
};