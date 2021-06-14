<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Db::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $roles = [
            ['role' => 'administrator'],
            ['role' => 'freelancer'],
            ['role' => 'employer'],
        ];

        DB::table('roles')->insert($roles);
    }
}
