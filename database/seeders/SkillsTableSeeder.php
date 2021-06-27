<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('skills')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $skills = [
            ['skill' => 'HTML'],
            ['skill' => 'CSS'],
            ['skill' => 'JS'],
            ['skill' => 'PHP'],
            ['skill' => 'Laravel'],
            ['skill' => 'Symfony'],
            ['skill' => 'Responsive'],
            ['skill' => 'Wordpress'],
            ['skill' => 'VueJS'],
            ['skill' => 'React'],
            ['skill' => 'Bootstrap'],
            ['skill' => 'iOS'],
            ['skill' => 'Android'],
            ['skill' => 'Mobile'],
            ['skill' => 'Python'],
            ['skill' => 'SEO'],
            ['skill' => 'Debugging'],
            ['skill' => 'Framework'],
            ['skill' => 'Git'],
            ['skill' => '.NET'],
            ['skill' => 'Agile'],
            ['skill' => 'Back-end'],
            ['skill' => 'Front-end'],
            ['skill' => 'Database'],
            ['skill' => 'Consulting'],
            ['skill' => 'Management'],
            ['skill' => 'Analytics'],
            ['skill' => 'WebApp'],
            ['skill' => 'API'],
            ['skill' => 'Angular'],
            ['skill' => 'Server'],
            ['skill' => 'CMS'],
        ];

        DB::table('skills')->insert($skills);
    }
}
