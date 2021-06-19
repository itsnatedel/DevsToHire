<?php
namespace Database\Seeders;
require_once 'vendor/autoload.php';

use Faker\Provider\en_US\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $faker->addProvider(new Company($faker));

        for ($i = 0; $i < 400; $i++) {
            $company_name = $faker->company;

            $companies[$i] = [
                'name'          => $company_name,
                'speciality'    => $faker->bs(),
                'slug'          => Str::slug($company_name),
                'description'   => $faker->paragraph(3, true),
                'pic_url'       => 'company-logo-0' . $faker->numberBetween(1, 6) . '.png',
                'verified'      => $faker->boolean(40),
                'user_id'       => $faker->numberBetween(2, 5),
                'location_id'   => $faker->numberBetween(1, 208)
            ];
        }

        DB::table('companies')->insert($companies);
    }
}
