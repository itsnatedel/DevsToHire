<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = [];
        
        $users[] = [ //1801
            'firstname'     => 'Jane',
            'lastname'      => 'Doe',
            'password'      => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2', // 12345678
            'email'         => 'company@gmail.com',
            'can_be_rated'  => $faker->boolean(),
            'pic_url'       => 'user-avatar-big-12.jpg',
            'dir_url'       => '321demo',
            'role_id'       => 3,
            'location_id'   => 18
        ];
        
        $users[] = [ //1802
            'firstname'     => 'Nate',
            'lastname'      => 'Doe',
            'password'      => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2', // 12345678
            'email'         => 'freelancer@gmail.com',
            'can_be_rated'  => $faker->boolean(),
            'pic_url'       => 'user-avatar-big-17.jpg',
            'role_id'       => 2,
            'location_id'   => 18,
            'dir_url'      => '123demo',
        ];
    
        $job = [ //800
            'title'         => 'Junior Laravel Developer needed !',
            'slug'          => 'junior-laravel-developer-needed',
            'created_at'    => $faker->dateTimeBetween('-4 weeks', '-1 day'),
            'description'   => 'We are currently looking for a new developer to join our Laravel dev team !',
            'salary_low'    => $faker->numberBetween(15000, 30000),
            'salary_high'   => $faker->numberBetween(31000, 70000),
            'company_id'    => 801,
            'remote'        => 'Work At Home',
            'type'          => 'Full Time',
            'category_id'   => 1,
            'featured'      => $faker->boolean(40),
            'only_locally'  => $faker->boolean(),
        ];
        
        $tasks = [ //800
            'name'          => 'Need help maintaining a WordPress page !',
            'slug'          => 'need-help-maintaining-a-wordpress-page',
            'description'   => 'We are in dire need of a developer who is able to maintain a shopping mall\'s website...',
            'budget_min'    => 90,
            'type'          => 'Fixed',
            'created_at'    => $faker->dateTimeBetween('-1 day'),
            'due_date'      => $faker->dateTimeBetween('+5 days', '+12 weeks'),
            'employer_id'   => 801,
            'category_id'   => 1,
            'location_id'   => 18,
        ];
    
        $jobDone = [
            'done_at'           => $faker->dateTimeBetween('-5 days'),
            'title'             => 'junior-laravel-developer-needed',
            'on_time'           => 1,
            'recommended'       => 1,
            'on_budget'         => 1,
            'rating'            => 4,
            'success'           => 1,
            'comment'           => 'Reliable developer with whom your projects are sure to be done correctly !',
            'job_id'            => 401,
            'freelancer_id'     => 1001,
            'employer_id'       => 801
        ];
        
        $company = [
            'name'          => 'EPFC Ltd.',
            'speciality'    => 'Teaching new Webdev talents',
            'slug'          => 'epfc-ltd',
            'description'   => $faker->realText('500', 5),
            'pic_url'       => 'company-logo-0' . $faker->numberBetween(1, 6) . '.png',
            'verified'      => 0,
            'user_id'       => 1801,
            'location_id'   => 18
        ];
    
        $freelancer = [
            'firstname'     => 'Nate',
            'lastname'      => 'Doe',
            'description'   => 'I am an inspiring web development student who wants to get his first experiences in the work life of being a WebDev freelance !',
            'pic_url'       => 'user-avatar-big-17.jpg',
            'hourly_rate'   => $faker->numberBetween(8, 40),
            'verified'      => $faker->boolean(60),
            'location_id'   => 18,
            'CV_url'        => 'TFE_trello.pdf',
            'category_id'   => 1,
            'joined_at'     => $faker->dateTimeBetween('-2 months', '-1 day'),
            'user_id'       => 1802
        ];
    
        $arr = [];
        $skills = DB::table('skills')->inRandomOrder()->limit(6)->get('skill');
    
        foreach ($skills as $skill) {
            $arr[] = $skill->skill;
        }
    
        $skillsFreelancer[] = [
            'freelancer_id' => 1001,
            'skills'  => json_encode($arr),
        ];
        
        $skillsJob = [
            'skills' => 'PHP, Laravel, MySQL',
            'job_id' => 401,
            'employer_id' => 801
        ];
    
        $skillsTask = [
            'skills' => 'PHP, Laravel, MySQL, Backend',
            'task_id' => 401,
        ];
    
        for ($i = 0; $i < 3; $i++) {
            $candidates[] = [
                'user_id'       => $faker->numberBetween(1, 1000),
                'employer_id'   => 801,
                'job_id'        => 401
            ];
        }
        
        $candidates[] = [
            'user_id'       => 1802,
            'employer_id'   => 801,
            'job_id'        => 401
        ];
        
        DB::table('users')->insert($users);
        DB::table('companies')->insert($company);
        DB::table('freelancers')->insert($freelancer);
        DB::table('users')
            ->where('email', '=', 'company@gmail.com')
            ->update([
                'company_id' => 801]);
        DB::table('users')
            ->where('email', '=', 'freelancer@gmail.com')
            ->update([
                'freelancer_id' => 1001]);
        
        DB::table('jobs')->insert($job);
        DB::table('tasks')->insert($tasks);
    
        $tasks = [
             'name'            => 'Need help maintaining a Laravel project !',
             'slug'            => 'need-help-maintaining-a-laravel-project',
             'description'     => 'I am in dire need of a developer who is able to maintain our small business page.',
             'budget_min'      => $faker->numberBetween(10, 90),
             'type'            => 'Hourly',
             'created_at'      => $faker->dateTimeBetween('-30 days', '-1 day'),
             'due_date'        => $faker->dateTimeBetween('+5 days', '+3 week'),
             'freelancer_id'   => 1001,
             'category_id'     => 1,
             'location_id'     => 18,
        ];
    
        DB::table('tasks')->insert($tasks);
        DB::table('freelancer_jobs_done')->insert($jobDone);
        DB::table('candidates')->insert($candidates);
        DB::table('skills_freelancers')->insert($skillsFreelancer);
        DB::table('skills_jobs')->insert($skillsJob);
        DB::table('skills_tasks')->insert($skillsTask);
    }
}