<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsFreelancersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('skills_freelancers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $freelancers = Freelancer::all();
        $skillsFreelancer = [];

        foreach ($freelancers as $freelancer) {
            $arr = [];
            $skills = DB::table('skills')->inRandomOrder()->limit(6)->get('skill');

            foreach ($skills as $skill) {
                $arr[] = $skill->skill;
            }

            $skillsFreelancer[] = [
                'freelancer_id' => $freelancer->id,
                'skills'  => json_encode($arr),
            ];
        }

        DB::table('skills_freelancers')->insert($skillsFreelancer);
    }
}
