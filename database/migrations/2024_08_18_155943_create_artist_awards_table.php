<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_awards', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('artist_id');  // artist_id: INT, foreign key
            $table->string('award_name');  // award_name: VARCHAR(255)
            $table->year('award_year');  // award_year: YEAR
            $table->text('details')->nullable();  // details: TEXT, nullable (受賞の詳細)
            $table->timestamps();  // created_at, updated_at: TIMESTAMP

            // Foreign key constraint
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_awards');
    }
}
