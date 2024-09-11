<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecipientIdToMessageSenderstable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('message_senders', function (Blueprint $table) {
            // recipientsカラムをjsonとして追加
            $table->json('recipients')->nullable()->after('sender_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('message_senders', function (Blueprint $table) {
            // recipientsカラムを削除
            $table->dropColumn('recipients');
        });
    }


}
