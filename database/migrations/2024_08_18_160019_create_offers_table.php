<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->string('title');  // title: VARCHAR(255)
            $table->text('description')->nullable();  // description: TEXT, nullable
            $table->integer('offer_type');  // offer_type: INT
            $table->integer('status');  // status: INT ' (0: offered, 1: accepted, 2: declined, 3: completed)
            $table->integer('max_artists')->nullable();  // max_artists: INT, nullable
            $table->json('artist_ids')->nullable();  // artist_ids: JSON, nullable
            $table->timestamp('offered_at')->nullable();  // offered_at: TIMESTAMP, nullable
            $table->timestamps();  // created_at, updated_at: TIMESTAMP
            $table->softDeletes();  // deleted_at: TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
