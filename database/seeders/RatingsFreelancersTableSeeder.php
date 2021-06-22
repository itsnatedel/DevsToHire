<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingsFreelancersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('ratings_freelancers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Factory::create();
        $ratings = [];

        for ($i = 0; $i < 2000; $i++) {
            $ratings[] = [
                'company_id'    => $faker->numberBetween(1, 400),
                'freelancer_id' => $faker->numberBetween(1, 800),
                'rated_as'      => $faker->randomElement(['Freelancer', 'Employer']),
                'note'          => $faker->numberBetween(1, 5),
                'comment'       => $faker->realText(120, 3),
                'when'          => $faker->dateTimeBetween('-30 days', '-1 day'),
            ];
        }

        DB::table('ratings_freelancers')->insert($ratings);
    }
}
