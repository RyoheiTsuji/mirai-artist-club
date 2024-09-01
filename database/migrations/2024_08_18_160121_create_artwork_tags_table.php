<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtworkTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_tags', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('artwork_id');  // artwork_id: INT, foreign key
            $table->unsignedBigInteger('tag_id');  // tag_id: INT, foreign key
            $table->timestamps();  // created_at, updated_at: TIMESTAMP

            // Foreign key constraints
            $table->foreign('artwork_id')->references('id')->on('artworks')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            // Unique constraint to ensure that a tag can be associated with an artwork only once
            $table->unique(['artwork_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artwork_tags');
    }
}
