<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageSendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_senders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id'); // メッセージID
            $table->unsignedBigInteger('sender_id'); // 送信者ID（アーティストまたは管理者）
            $table->string('sender_type'); // 'artist' または 'admin'
            $table->timestamps();

            // 外部キーの制約
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            // sender_id は複数のテーブルを参照する可能性があるため、foreignキーの設定は行わない
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_senders');
    }


}
