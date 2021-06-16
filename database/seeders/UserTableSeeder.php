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

        $users = [
            [
                'firstname' => 'Bob',
                'lastname' => 'Sull',
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2', // 12345678
                'email' => 'bob@gmail.com',
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => 'John',
                'lastname' => 'McCain',
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => 'nathan@gmail.com',
                'role_id' => 3,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 3,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 3,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 3,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
            [
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'password' => '$2y$10$O8TR5s3ouefCXXR9lAyetuT0i2cpuG3z0uxSk1e3rAIWnLnJJIVf2',
                'email' => $faker->email,
                'role_id' => 2,
                'location_id' => $faker->numberBetween(1, 208),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
