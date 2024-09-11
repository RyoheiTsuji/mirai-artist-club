<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // 自動インクリメントのid
            $table->unsignedBigInteger('parent_id')->nullable(); // 親メッセージID（返信機能を想定）
            $table->unsignedBigInteger('sender_id'); // 管理者またはアーティストのID（必須）
            $table->string('title')->nullable(); // メッセージのタイトル（任意）
            $table->text('content'); // メッセージ内容（必須）
            $table->unsignedTinyInteger('status')->default(0); // メッセージのステータス、初期値は0
            $table->timestamps(); // created_at, updated_at

            // 外部キー制約を追加
            $table->foreign('sender_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade'); // アーティスト削除時にメッセージも削除

            // 必要に応じて、parent_idに自己参照制約を追加
            $table->foreign('parent_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
