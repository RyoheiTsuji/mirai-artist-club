<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $startDate = Carbon::create('2024', '06', '06'); // 開始日
        $endDate = Carbon::create('2024', '08', '24'); // 終了日

        for ($i = 0; $i < 50; $i++) {
            DB::table('artists')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // ハッシュ化したパスワード
                'bio' => $faker->paragraph,
                'pr_statement' => $faker->paragraph,
                'address' => $faker->address,
                'birthday' => $faker->date('Y-m-d', '2000-01-01'), // 適当な生年月日
                'phone_number' => $faker->phoneNumber,
                'created_at' => $faker->dateTimeBetween($startDate, $endDate),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
        }
    }
}
