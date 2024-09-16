<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAnnouncementsTableRemoveClosedDate extends Migration
{
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // 新しいカラムを追加
            $table->integer('content_type')->default(0)->after('user_type');  // お知らせの種類: 0->イベント, 1->その他
            $table->date('event_start_date')->nullable()->after('content_type');  // イベント開始日
            $table->date('event_end_date')->nullable()->after('event_start_date'); // イベント終了日
            $table->date('publish_start_date')->nullable()->after('event_end_date'); // 掲載開始日
            $table->date('publish_end_date')->nullable()->after('publish_start_date'); // 掲載終了日
            $table->boolean('calendar_flag')->default(false)->after('publish_end_date'); // カレンダーフラグ
            $table->string('photo_url')->nullable()->after('calendar_flag'); // 画像URL
        });
    }

    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // カラムを削除
            $table->dropColumn([
                'event_start_date',
                'event_end_date',
                'publish_start_date',
                'publish_end_date',
                'calendar_flag',
                'photo_url',
                'author_id'
            ]);
        });
    }
}
