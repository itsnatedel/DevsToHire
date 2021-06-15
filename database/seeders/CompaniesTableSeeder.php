<?php
namespace Database\Seeders;
require_once 'vendor/autoload.php';

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('companies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $companies = [];

        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $companies[$i] = [
                'name' => $faker->company,
                'description' => $faker->paragraph(3, true),
                'verified' => 0,
                'user_id' => $faker->numberBetween(2, 5),
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
