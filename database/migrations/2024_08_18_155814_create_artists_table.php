<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->string('name');  // name: VARCHAR(255)
            $table->string('email')->unique();  // email: VARCHAR(255) <<UNIQUE>>
            $table->string('password')->nullable();  // password: VARCHAR(255)
            $table->text('bio')->nullable();  // bio: TEXT
            $table->text('pr_statement')->nullable();  // pr_statement: TEXT
            $table->string('address', 255)->nullable();  // address: VARCHAR(255)
            $table->string('postal_code', 20)->nullable();  // postal_code: VARCHAR(20)
            $table->date('birthday')->nullable();  // birthday: DATE ' YYYY-MM-DD
            $table->string('phone_number', 20)->nullable();  // phone_number: VARCHAR(20)
            $table->string('photo_url', 255)->nullable();  // photo_url: VARCHAR(255)
            $table->timestamp('email_verified_at')->nullable();  // email_verified_at: TIMESTAMP
            $table->tinyInteger('verified')->default(0);  // verified: TINYINT(1), default 0
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
        Schema::dropIfExists('artists');
    }
}
