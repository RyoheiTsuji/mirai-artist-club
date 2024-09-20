<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleAndReasonToArtworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artworks', function (Blueprint $table) {
            // material の後に 'sale' カラム (json) と 'reason' カラム (varchar) を追加
            $table->json('sale')->default(json_encode([0]))->after('material'); // デフォルトで [0] の配列
            $table->string('reason', 255)->nullable()->after('sale'); // NULL 許容の reason カラム
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artworks', function (Blueprint $table) {
            // 追加したカラムを削除
            $table->dropColumn('sale');
            $table->dropColumn('reason');
        });
    }
}
