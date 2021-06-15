<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PremiumUsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('premium_users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Factory::create();
        $premiumUsers = [];

        for ($i = 0; $i < 10; $i++) {
            $premiumUsers[] = [
                'date_bought'   => $faker->dateTimeBetween('-2 weeks'),
                'user_id'       => $faker->numberBetween(2, 21),
                'plan_id'       => $faker->numberBetween(1, 3)
            ];
        }

        DB::table('premium_users')->insert($premiumUsers);
    }
}
