<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();  // id: INT <<PK>>
            $table->unsignedBigInteger('user_id');  // user_id: INT ' 問合せ者のID (artists, admins, users)
            $table->integer('user_type');  // user_type: INT ' 問合せ者のタイプ ("2: user", "1: artist", "0: admin")
            $table->integer('inq_type');  // inq_type: INT ' 問合せの種類
            $table->string('subject');  // subject: VARCHAR(255) ' 件名
            $table->text('message');  // message: TEXT ' 内容
            $table->integer('status')->default(0);  // status: INT ' (0: unread, 1: read, 2: replied, 3: closed)
            $table->unsignedBigInteger('parent_id')->nullable();  // parent_id: INT <<FK>>, nullable
            $table->timestamps();  // created_at, updated_at: TIMESTAMP
            $table->softDeletes();  // deleted_at: TIMESTAMP

            // Foreign key constraints
            $table->foreign('parent_id')->references('id')->on('inquiries')->onDelete('cascade');

            // Index for user_id and user_type
            $table->index(['user_id', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
}
