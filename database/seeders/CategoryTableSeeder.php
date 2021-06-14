<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $categories = [
            ['icon' => 'icon-line-awesome-file-code-o', 'name' => 'Web & Software Dev', 'description' => 'Software Engineer, Web / Mobile Developer & More'],
            ['icon' => 'icon-line-awesome-cloud-upload', 'name' => 'Data Science & Analytics', 'description' => 'Data Specialist / Scientist, Data Analyst & More'],
            ['icon' => 'icon-line-awesome-suitcase', 'name' => 'Accounting & Consulting', 'description' => 'Auditor, Accountant, Financial Analyst & More'],
            ['icon' => 'icon-line-awesome-pencil', 'name' => 'Writing & Translations', 'description' => 'Copywriter, Creative Writer, Translator & More'],
            ['icon' => 'icon-line-awesome-pie-chart', 'name' => 'Sales & Marketing', 'description' => 'Brand Manager, Marketing Coordinator & More'],
            ['icon' => 'icon-line-awesome-image', 'name' => 'Graphics & Design', 'description' => 'Creative Director, Web Designer & More'],
            ['icon' => 'icon-line-awesome-bullhorn', 'name' => 'Digital Marketing', 'description' => 'Marketing Analyst, Social Profile Admin & More'],
            ['icon' => 'icon-line-awesome-graduation-cap', 'name' => 'Education & Training', 'description' => 'Advisor, Coach, Education Coordinator & More'],
        ];

        DB::table('categories')->insert($categories);
    }
}
