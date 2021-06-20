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

        DB::table('ratings')->insert($ratings);
    }
}
