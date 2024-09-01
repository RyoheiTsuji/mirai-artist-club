<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->string('name')->unique();  // name: VARCHAR(255) <<UNIQUE>>
            $table->text('description')->nullable();  // description: TEXT, nullable (タグに関する説明やメモ)
            $table->timestamps();  // created_at, updated_at: TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
