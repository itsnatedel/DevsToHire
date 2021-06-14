<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('locations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $locations = [
            ['country' => 'Belgium', 'country_flag_url' => 'belgium.png'],
            ['country' => 'France', 'country_flag_url' => 'France.png'],
            ['country' => 'Spain', 'country_flag_url' => 'Spain.png'],
        ];

        DB::table('locations')->insert($locations);
    }
}
