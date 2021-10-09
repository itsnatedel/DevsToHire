<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('bids')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Factory::create();
        $bids = [];

        for($i = 0; $i < 50; $i++) {
            $bids[] = [
                'minimal_rate'  => $faker->numberBetween(600, 4000),
                'delivery_time' => $faker->numberBetween(1, 30),
                'time_period'   => $faker->randomElement(['Days', 'Hours']),
                'bidder_id'     => $faker->numberBetween(1, 15),
                'task_id'       => $faker->numberBetween(1, 40),
                'created_at'    => $faker->dateTimeBetween('-4 weeks', '-1 day'),
            ];
        }

        DB::table('bids')->insert($bids);
    }
}