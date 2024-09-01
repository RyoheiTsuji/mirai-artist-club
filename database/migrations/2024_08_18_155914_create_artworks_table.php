<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('artist_id');  // artist_id: INT, foreign key
            $table->string('title');  // title: VARCHAR(255)
            $table->text('description')->nullable();  // description: TEXT, nullable
            $table->string('image_path');  // image_path: VARCHAR(255)
            $table->integer('year')->nullable();  // year: INT, nullable (制作年)
            $table->string('size', 50)->nullable();  // size: VARCHAR(50), nullable (サイズ)
            $table->timestamps();  // created_at, updated_at: TIMESTAMP
            $table->softDeletes();  // deleted_at: TIMESTAMP

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
        Schema::dropIfExists('artworks');
    }
}
