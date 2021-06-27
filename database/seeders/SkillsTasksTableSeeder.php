<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class SkillsTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('skills_tasks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $tasks = Task::all();
        $skillsTask = [];

        foreach ($tasks as $task) {
            $arr = [];
            $skills = DB::table('skills')->inRandomOrder()->limit(5)->get('skill');

            foreach ($skills as $skill) {
                $arr[] = $skill->skill;
            }

            $skillsTask[] = [
                'task_id' => $task->id,
                'skills'  => json_encode($arr),
            ];
        }

        DB::table('skills_tasks')->insert($skillsTask);
    }
}
