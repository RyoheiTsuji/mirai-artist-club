<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('user_id');  // user_id: INT (外部キーの代わりに使用)
            $table->string('user_type');  // user_type: VARCHAR(255) ' 管理者、アーティストなどの区別
            $table->string('title');  // title: VARCHAR(255)
            $table->text('content');  // content: TEXT ' お知らせの内容
            $table->timestamps();  // created_at, updated_at: TIMESTAMP
            $table->softDeletes();  // deleted_at: TIMESTAMP

            // Polymorphic index for user
            $table->index(['user_id', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
