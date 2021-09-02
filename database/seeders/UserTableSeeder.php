<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Faker::create();
        $users = [];

        for ($i = 0; $i < 85; $i++) {
            $randomInt = $faker->numberBetween(1, 30);

            if ($randomInt < 10) {
                $randomInt = '0' . $randomInt;
            }

            $users[] = [
                'firstname' => $faker->name(),
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2', // 12345678
                'email' => $faker->email,
                'can_be_rated' => $faker->boolean(),
                'pic_url' => 'user-avatar-big-' . $randomInt . '.jpg',
                'role_id' => $faker->numberBetween(2, 3),
                'location_id' => $faker->numberBetween(1, 208),
            ];
        }

        DB::table('users')->insert($users);
    }
}
