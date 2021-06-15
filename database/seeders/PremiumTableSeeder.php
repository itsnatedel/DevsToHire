<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PremiumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('premium')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $description = "One time fee for one listing or task highlighted in search results.";

        $plans = [
            [
                'plan' => 'Basic',
                'description' => $description,
                'monthly_price' => 19,
                'yearly_price' => 180,
                'listing' => 1,
                'visibility_days' => 30,
            ],
            [
                'plan' => 'Standard',
                'description' => $description,
                'monthly_price' => 35,
                'yearly_price' => 215,
                'listing' => 5,
                'visibility_days' => 60,
            ],
            [
                'plan' => 'Extended',
                'description' => $description,
                'monthly_price' => 50,
                'yearly_price' => 275,
                'listing' => 'Unlimited',
                'visibility_days' => 90,
            ],
        ];

        DB::table('premium')->insert($plans);
    }
}
