<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->string('furigana')->after('name'); // 'name'カラムの後に追加
        });
    }

    public function down()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('furigana'); // 追加したカラムを削除
        });
    }
};
