<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaterialToArtworksTable extends Migration
{
    public function up()
    {
        Schema::table('artworks', function (Blueprint $table) {
            // materialカラムを追加
            $table->string('material')->after('size_h');

            // yearカラムを削除
            $table->dropColumn('year');
        });
    }

    public function down()
    {
        Schema::table('artworks', function (Blueprint $table) {
            // yearカラムを再追加
            $table->integer('year')->after('material'); // データ型は元の型に合わせてください

            // materialカラムを削除
            $table->dropColumn('material');
        });
    }
}
