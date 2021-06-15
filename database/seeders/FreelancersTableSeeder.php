<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Provider\en_US\Text as Text;

class FreelancersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('freelancers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Factory::create();
        $text = new Text($faker);

        $freelancers = [];

        for ($i = 0; $i < 15; $i++) {
            $freelancers[] = [
                'description' => $text->realText(255),
                'hourly_rate' => $faker->numberBetween(8, 70),
                'verified'    => $faker->boolean(30),
                'user_id'     => $faker->unique()->numberBetween(6, 21)
            ];
        }

        DB::table('freelancers')->insert($freelancers);
    }
}
