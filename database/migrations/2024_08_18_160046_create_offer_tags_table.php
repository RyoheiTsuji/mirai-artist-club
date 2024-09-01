<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_tags', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('offer_id');  // offer_id: INT, foreign key
            $table->unsignedBigInteger('tag_id');  // tag_id: INT, foreign key
            $table->timestamps();  // created_at, updated_at: TIMESTAMP

            // Foreign key constraints
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            // Unique constraint to ensure that a tag can be associated with an offer only once
            $table->unique(['offer_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_tags');
    }
}
