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
            'dir_url'       => null,
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
            'salary_high'   => $faker->numberBetween(31000, 60000),
            'company_id'    => 801,
            'remote'        => $faker->randomElement(['Work At Home', 'Temporarily', 'No']),
            'type'          => $faker->randomElement(['Full Time', 'Freelance', 'Part Time', 'Internship', 'Temporary']),
            'category_id'   => $faker->numberBetween(1, 8),
            'featured'      => $faker->boolean(40),
            'only_locally'  => $faker->boolean(),
        ];
    
        $task = [ //800
            'name'          => 'Need help maintaining a WordPress page !',
            'slug'          => 'need-help-maintaining-a-wordpress-page',
            'description'   => 'We are in dire need of a developer who is able to maintain a shopping mall\'s website...',
            'budget_min'    => $faker->numberBetween(10, 90),
            'type'          => $faker->randomElement(['Fixed', 'Hourly']),
            'created_at'    => $faker->dateTimeBetween('-30 days', '-1 day'),
            'due_date'      => $faker->dateTimeBetween('+5 days', '+12 weeks'),
            'employer_id'   => 801,
            'category_id'   => $faker->numberBetween(1, 8),
            'location_id'   => 18,
        ];
    
        $company = [
            'name'          => 'EPFC Corp. Ltd.',
            'speciality'    => 'Teaching new talents and put them in the WebDev spotlight !',
            'slug'          => 'teaching-new-talents-and-putting-them-in-the-webdev-spotlight',
            'description'   => $faker->paragraph(3, true),
            'pic_url'       => 'company-logo-0' . $faker->numberBetween(1, 6) . '.png',
            'verified'      => $faker->boolean(40),
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
            'category_id'   => $faker->numberBetween(1, 8),
            'joined_at'     => $faker->dateTimeBetween('-2 years', '-1 day'),
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
            'skills' => 'PHP, Laravel, MySQL',
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
        DB::table('tasks')->insert($task);
        DB::table('candidates')->insert($candidates);
        DB::table('skills_freelancers')->insert($skillsFreelancer);
        DB::table('skills_jobs')->insert($skillsJob);
        DB::table('skills_tasks')->insert($skillsTask);
    }
}