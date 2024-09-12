<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            // 管理者、アーティスト、一般ユーザそれぞれのカラムを追加
            $table->unsignedBigInteger('created_by_admin_id')->nullable()->after('user_type');
            $table->unsignedBigInteger('created_by_artist_id')->nullable()->after('created_by_admin_id');
            $table->unsignedBigInteger('submitted_by_user_id')->nullable()->after('created_by_artist_id'); // user_idの別名

            // 外部キー制約も追加
            $table->foreign('created_by_admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('created_by_artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('submitted_by_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            // 外部キー制約の削除
            $table->dropForeign(['created_by_admin_id']);
            $table->dropForeign(['created_by_artist_id']);
            $table->dropForeign(['submitted_by_user_id']);

            // カラムの削除
            $table->dropColumn(['created_by_admin_id', 'created_by_artist_id', 'submitted_by_user_id']);
        });


    }

};
