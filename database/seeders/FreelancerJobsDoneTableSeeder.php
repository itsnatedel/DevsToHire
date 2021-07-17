<?php

namespace Database\Seeders;

use Faker\Factory;
use Faker\Provider\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreelancerJobsDoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('freelancer_jobs_done')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $jobsDone = [];

        $faker = Factory::create();
        $faker->addProvider(new Company($faker));

        for ($i = 0; $i < 4000; $i++) {
            $jobsDone[] = [
                'on_time'       => $faker->boolean(),
                'recommended'   => $faker->boolean(),
                'on_budget'     => $faker->boolean(),
                'rating'        => $faker->numberBetween(0, 5),
                'comment'       => $faker->realText(400, 3),
                'done_at'       => $faker->dateTimeBetween('-2 months'),
                'title'         => $faker->bs(),
                'job_id'        => $faker->numberBetween(1, 400),
                'employer_id'   => $faker->numberBetween(1, 400),
                'freelancer_id' => $faker->numberBetween(1, 1000),
                'success'       => $faker->boolean(),
            ];
        }

        DB::table('freelancer_jobs_done')->insert($jobsDone);
    }
}
