<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArtworksTableAddSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artworks', function (Blueprint $table) {
            // size_wとsize_hをnullableにする
            $table->integer('size_w')->nullable()->change();
            $table->integer('size_h')->nullable()->change();

            // size_dカラムを追加
            $table->integer('size_d')->nullable()->after('size_h');

            // size_oカラムを追加
            $table->string('size_o', 255)->nullable()->after('size_d');
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
            // size_oカラムを削除
            $table->dropColumn('size_o');

            // size_dカラムを削除
            $table->dropColumn('size_d');

            // size_wとsize_hをnot nullableに戻す
            $table->integer('size_w')->nullable(false)->change();
            $table->integer('size_h')->nullable(false)->change();
        });
    }
}
