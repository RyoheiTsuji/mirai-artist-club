<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Support\Str;

class InquirySeeder extends Seeder
{
    public function run()
    {
        // 一般ユーザの問い合わせデータを生成
        $user1 = User::create([
            'name' => '一般ユーザ太郎',
            'email' => 'user1@example.com',
        ]);

        Inquiry::create([
            'user_type' => 2, // 一般ユーザ
            'user_id' => $user1->id,
            'inq_type' => rand(1, 4), // ランダムな問い合わせタイプ
            'status' => 0, // デフォルトの未解決ステータス
            'subject' => 'サービス利用方法について',
            'message' => 'このサービスの利用方法について教えてください。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user2 = User::create([
            'name' => '一般ユーザ花子',
            'email' => 'user2@example.com',
        ]);

        Inquiry::create([
            'user_type' => 2, // 一般ユーザ
            'user_id' => $user2->id,
            'inq_type' => rand(1, 4), // ランダムな問い合わせタイプ
            'status' => 1, // 進行中
            'subject' => '機能について',
            'message' => 'この機能はどのように動作しますか？',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 作家の問い合わせデータを生成
        $artist1 = Artist::create([
            'name' => '作家一郎',
            'email' => 'artist1@example.com',
            'password' => bcrypt('password'),
            'level' => 1,
        ]);

        Inquiry::create([
            'user_type' => 1, // 作家
            'user_id' => $artist1->id,
            'inq_type' => rand(1, 4), // ランダムな問い合わせタイプ
            'status' => 0, // デフォルトの未解決ステータス
            'subject' => 'オファー詳細',
            'message' => 'このオファーの詳細について知りたいです。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $artist2 = Artist::create([
            'name' => '作家二郎',
            'email' => 'artist2@example.com',
            'password' => bcrypt('password'),
            'level' => 2,
        ]);

        Inquiry::create([
            'user_type' => 1, // 作家
            'user_id' => $artist2->id,
            'inq_type' => rand(1, 4), // ランダムな問い合わせタイプ
            'status' => 1, // 進行中
            'subject' => '支払いスケジュール',
            'message' => '支払いのスケジュールについて教えてください。',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
