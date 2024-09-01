<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->string('name');  // name: VARCHAR(255)
            $table->string('email')->unique();  // email: VARCHAR(255) <<UNIQUE>>
            $table->string('password');  // password: VARCHAR(255)
            $table->string('remember_token', 100)->nullable();  // remember_token: VARCHAR(100), nullable
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
        Schema::dropIfExists('admins');
    }
}
