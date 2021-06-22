<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('ratings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $ratings = [];
        $faker = Factory::create();

        for ($i = 0; $i < 8; $i++) {
            $ratings[] = [
                'voter_id'      => $faker->numberBetween(1, 21),
                'rated_user'    => $faker->numberBetween(1, 21),
                'note'          => $faker->numberBetween(0, 5),
            ];
        }

        DB::table('ratings')->insert($ratings);
    }
}
