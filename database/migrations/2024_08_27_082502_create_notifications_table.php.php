<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artist_id')->nullable(); // 通知を受け取る管理者のID
            $table->string('type'); // 通知の種類
            $table->text('data'); // 通知に関する追加情報（JSON形式）
            $table->boolean('is_read')->default(false); // 既読ステータス
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

