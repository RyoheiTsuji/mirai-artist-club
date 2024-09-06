<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;

class UpdateArtistLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // level が 1 のアーティストをランダムに 2 または 3 に更新
        Artist::where('level', 1)->get()->each(function ($artist) {
            $artist->update(['level' => rand(2, 3)]);
        });
    }
}
