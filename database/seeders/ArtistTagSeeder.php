<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  // ここでインポート
use Illuminate\Support\Str;

class ArtistTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 使用するタグIDの範囲
        $availableTagIds = array_merge([1], range(3, 16));

        // 1から51までのartist_idごとに3つのタグをランダムに割り当てる
        for ($artistId = 1; $artistId <= 51; $artistId++) {
            // タグIDの配列からランダムに3つ選択
            $randomTags = array_rand(array_flip($availableTagIds), 3);

            foreach ($randomTags as $tagId) {
                DB::table('artist_tags')->insert([
                    'artist_id' => $artistId,
                    'tag_id' => $tagId,
                ]);
            }
        }
    }
}
