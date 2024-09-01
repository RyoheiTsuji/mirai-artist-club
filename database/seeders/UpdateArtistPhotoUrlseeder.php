<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateArtistPhotoUrlSeeder extends Seeder
{
    public function run()
    {
        // `photo_url` が空のレコードを対象に `photo_url` に `artist_photo/2.jpg` を設定
        DB::table('artists')
            ->whereNull('photo_url') // `photo_url` が NULL のレコードを検索
            ->orWhere('photo_url', '') // または `photo_url` が空文字のレコードを検索
            ->update(['photo_url' => 'artist_photo/2.jpg']); // 更新する値
    }
}

