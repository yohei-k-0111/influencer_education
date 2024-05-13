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
        Schema::create('delivery_times', function (Blueprint $table) {
            $table->increments('id'); // int(10) のid
            $table->unsignedInteger('curriculums_id'); // 符号なしint(10) のカリキュラムid notnull
            $table->dateTime('delivery_from'); // datetime(YYYYMMDDhhmmss) の公開開始日 notnull
            $table->dateTime('delivery_to'); // datetime(YYYYMMDDhhmmss) の公開終了日 notnull
            $table->timestamps(); // 作成日時created_at と 更新日時updated_at のtimestamp

            // 外部キー制約を追加
            $table->foreign('curriculums_id')
                  ->references('id')
                  ->on('curriculums')
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
        Schema::dropIfExists('delivery_times');
    }
};