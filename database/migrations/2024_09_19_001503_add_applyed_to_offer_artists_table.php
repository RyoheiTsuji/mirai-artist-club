<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplyedToOfferArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_artists', function (Blueprint $table) {
            $table->tinyInteger('applyed')->default(0)->after('artist_id'); // applyedカラムを追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_artists', function (Blueprint $table) {
            $table->dropColumn('applyed');
        });
    }
}
