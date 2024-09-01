<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_tags', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('artist_id');  // artist_id: INT, foreign key
            $table->unsignedBigInteger('tag_id');  // tag_id: INT, foreign key
            $table->timestamps();  // created_at, updated_at: TIMESTAMP

            // Foreign key constraints
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            // Unique constraint to ensure that a tag can be associated with an artist only once
            $table->unique(['artist_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_tags');
    }
}
