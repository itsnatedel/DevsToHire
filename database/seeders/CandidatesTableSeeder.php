<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('candidates')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Factory::create();
        $candidates = [];

        for($i = 0; $i < 20; $i++) {
            $candidates[] = [
                'user_id'   => $faker->numberBetween(6, 21),
                'job_id'    => $faker->numberBetween(1, 60)
            ];
        }

        DB::table('candidates')->insert($candidates);
    }
}
