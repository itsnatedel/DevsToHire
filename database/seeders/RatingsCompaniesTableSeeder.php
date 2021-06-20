<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('ratings_companies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Factory::create();
        $ratings = [];

        for ($i = 0; $i < 2000; $i++) {
            $ratings[] = [
                'company_id'    => $faker->numberBetween(1, 400),
                'freelancer_id' => $faker->numberBetween(1, 800),
                'note'          => $faker->numberBetween(1, 5),
                'comment'       => $faker->realText(120, 4),
                'when'          => $faker->dateTimeBetween('-30 days', '-1 day'),
            ];
        }

        DB::table('ratings_companies')->insert($ratings);
    }
}
