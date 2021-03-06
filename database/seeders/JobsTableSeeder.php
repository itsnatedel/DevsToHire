<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Provider\en_US\Company;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('jobs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $jobs = [];
        $faker = Faker::create();
        $company = new Company($faker);
        
        for ($i = 0; $i < 400; $i++) {
            $title = $company->catchPhrase();
            $jobs[$i] = [
                'title'         => $title,
                'slug'          => Str::slug($title),
                'created_at'    => $faker->dateTimeBetween('-4 weeks', '-1 day'),
                'description'   => $faker->realText(800, 5),
                'salary_low'    => $faker->numberBetween(15000, 30000),
                'salary_high'   => $faker->numberBetween(31000, 60000),
                'company_id'    => $faker->numberBetween(1, 50),
                'remote'        => $faker->randomElement(['Work At Home', 'Temporarily', 'No']),
                'type'          => $faker->randomElement(['Full Time', 'Freelance', 'Part Time', 'Internship', 'Temporary']),
                'category_id'   => $faker->numberBetween(1, 8),
                'featured'      => $faker->boolean(40),
                'only_locally'  => $faker->boolean(40),
            ];
        }

        DB::table('jobs')->insert($jobs);
    }
}