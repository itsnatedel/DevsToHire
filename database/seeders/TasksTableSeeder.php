<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Faker\Provider\en_US\Text as Text;
use Faker\Provider\en_US\Company as Company;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('tasks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $tasks = [];
        $faker = Faker::create();
        $text = new Text($faker);
        $company = new Company($faker);

        for ($i = 0; $i < 500; $i++) {
            $tasks[] = [
                'name'          => $company->bs(),
                'description'   => $text->realText(255),
                'budget_min'    => $faker->numberBetween(500, 3000),
                'budget_max'    => $faker->numberBetween(3100, 6000),
                'type'          => $faker->randomElement(['Fixed', 'Hourly']),
                'due_date'      => $faker->dateTimeBetween('-1 day', '+12 weeks'),
                'employer_id'   => $faker->numberBetween(1, 400),
                'category_id'   => $faker->numberBetween(1, 8)
            ];
        }

        DB::table('tasks')->insert($tasks);
    }
}
