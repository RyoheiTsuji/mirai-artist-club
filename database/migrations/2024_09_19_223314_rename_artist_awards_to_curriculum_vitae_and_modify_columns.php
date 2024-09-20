<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameArtistAwardsToCurriculumVitaeAndModifyColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // テーブル名の変更
        Schema::rename('artist_awards', 'curriculum_vitae');

        // カラム名の変更
        Schema::table('curriculum_vitae', function (Blueprint $table) {
            $table->renameColumn('award_year', 'year');
            $table->renameColumn('award_details', 'detail');
        });

        // 'year' の後に 'month' カラムを追加（カラム名の変更後に行う）
        Schema::table('curriculum_vitae', function (Blueprint $table) {
            $table->integer('month')->after('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 'month' カラムを削除
        Schema::table('curriculum_vitae', function (Blueprint $table) {
            $table->dropColumn('month');
        });

        // カラム名を元に戻す
        Schema::table('curriculum_vitae', function (Blueprint $table) {
            $table->renameColumn('year', 'award_year');
            $table->renameColumn('detail', 'award_details');
        });

        // テーブル名を元に戻す
        Schema::rename('curriculum_vitae', 'artist_awards');
    }
}
