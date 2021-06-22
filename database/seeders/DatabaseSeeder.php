<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        $this->call([
            LocationsTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
            CategoryTableSeeder::class,
            CompaniesTableSeeder::class,
            TasksTableSeeder::class,
            PremiumTableSeeder::class,
            FreelancersTableSeeder::class,
            RatingsTableSeeder::class,
            JobsTableSeeder::class,
            CandidatesTableSeeder::class,
            TasksTableSeeder::class,
            BidsTableSeeder::class,
            PremiumUsersTable::class
        ]);
    }
}
