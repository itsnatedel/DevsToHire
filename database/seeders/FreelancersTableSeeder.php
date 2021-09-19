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

        for ($i = 0; $i < 1000; $i++) {

            $randomInt = $faker->numberBetween(1, 30);

            if ($randomInt < 10) {
                $randomInt = '0' . $randomInt;
            }


            $freelancers[] = [
                'firstname'     => $faker->firstName(),
                'lastname'      => $faker->lastName(),
                'description'   => $text->realText(255),
                'pic_url'       => 'user-avatar-big-' . $randomInt . '.jpg',
                'hourly_rate'   => $faker->numberBetween(8, 70),
                'success_rate'  => $faker->numberBetween(60, 100),
                'verified'      => $faker->boolean(70),
                'location_id'   => $faker->numberBetween(1, 208),
                'category_id'   => $faker->numberBetween(1, 8),
                'joined_at'     => $faker->dateTimeBetween('-2 years', '-1 day')
            ];
        }

        DB::table('freelancers')->insert($freelancers);
    }
}
