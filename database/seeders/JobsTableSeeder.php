<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Faker\Provider\en_US\Company;
use Faker\Provider\en_US\Text;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'description'   => $faker->text(800),
                'salary_low'    => $faker->numberBetween(15000, 30000),
                'salary_high'   => $faker->numberBetween(31000, 60000),
                'company_id'    => $faker->numberBetween(1, 50),
                'remote'        => $faker->randomElement(['Work At Home', 'Temporarily', 'No']),
                'type'          => $faker->randomElement(['Full Time', 'Freelance', 'Part Time', 'Internship', 'Temporary']),
                'category_id'   => $faker->numberBetween(1, 8),
                'open'          => $faker->boolean(60),
                'featured'      => $faker->boolean(60),
            ];
        }

        DB::table('jobs')->insert($jobs);
    }
}
