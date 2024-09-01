<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_artists', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('offer_id');  // offer_id: INT, foreign key
            $table->unsignedBigInteger('artist_id');  // artist_id: INT, foreign key
            $table->timestamps();  // created_at, updated_at: TIMESTAMP

            // Foreign key constraints
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');

            // Unique constraint to ensure that an artist can be associated with an offer only once
            $table->unique(['offer_id', 'artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_artists');
    }
}
