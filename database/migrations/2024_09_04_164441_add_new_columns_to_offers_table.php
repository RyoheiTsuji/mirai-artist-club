<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string('duration')->nullable()->after('title'); // 案件期間 (Xヶ月 or X月○日～△月□日)
            $table->integer('recruit_number')->nullable()->after('duration'); // 募集人数
            $table->integer('budget')->nullable()->after('recruit_number'); // 案件予算
            $table->date('application_deadline')->nullable()->after('budget'); // 募集締め切り
            $table->string('reward')->nullable()->after('application_deadline'); // 報酬
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('duration');
            $table->dropColumn('recruit_number');
            $table->dropColumn('budget');
            $table->dropColumn('application_deadline');
            $table->dropColumn('reward');
        });
    }

}
