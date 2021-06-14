<?php
namespace Database\Seeders;
require_once 'vendor/autoload.php';

use Faker\Provider\Company;
use Faker\Provider\en_US\Text;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

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
                'verified' => 0
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
