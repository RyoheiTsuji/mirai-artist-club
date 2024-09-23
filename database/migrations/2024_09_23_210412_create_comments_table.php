<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // コメントのID
            $table->unsignedBigInteger('artist_id'); // 作家のID
            $table->text('content'); // コメント内容
            $table->tinyInteger('status')->default(1); // 公開/非公開ステータス (1: 公開, 0: 非公開)
            $table->timestamps(); // created_at, updated_at

            // 外部キー制約
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
