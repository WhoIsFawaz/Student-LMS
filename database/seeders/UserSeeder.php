<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Hardcoded data
        $hardcodedData = [
            ['first_name' => 'Muhammad', 'last_name' => 'Syahmi', 'email' => 'syahmi@eduhub.com', 'date_of_birth' => '1996-07-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/m.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Cao', 'last_name' => 'Qi', 'email' => 'caoqi@eduhub.com', 'date_of_birth' => '1996-07-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/c.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'John', 'last_name' => 'Binder', 'email' => 'binder@eduhub.com', 'date_of_birth' => '1992-07-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/j.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane.doe@eduhub.com', 'date_of_birth' => '1986-07-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/j.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Alex', 'last_name' => 'Smith', 'email' => 'alex.smith@eduhub.com', 'date_of_birth' => '1999-08-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/a.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Vignesh', 'last_name' => 'Bala', 'email' => 'vignesh.bala@eduhub.com', 'date_of_birth' => '1933-08-22', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/r.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Hilman', 'last_name' => 'Afiq', 'email' => 'hilman.afiq@eduhub.com', 'date_of_birth' => '1996-11-05', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/h.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Abdul', 'last_name' => 'Hakam', 'email' => 'abdul.hakam@eduhub.com', 'date_of_birth' => '1985-10-15', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/a.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Chris', 'last_name' => 'Kalendario', 'email' => 'chris.kalendario@eduhub.com', 'date_of_birth' => '1990-12-12', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/c.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Nelson', 'last_name' => 'Mandela', 'email' => 'nelson.mandela@eduhub.com', 'date_of_birth' => '1998-07-18', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/n.png', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Zuhairi', 'last_name' => 'Hamzah', 'email' => 'zuhairi.hamzah@eduhub.com', 'date_of_birth' => '1992-06-21', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/z.png', 'created_at' => now(), 'updated_at' => now()]
        ];

        // Faker-generated data
        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'date_of_birth' => $faker->date,
                'password' => Hash::make('password'), // default password
                'user_type' => $faker->randomElement(['professor', 'student']),
                'profile_picture' => '/seeder-media/' . $faker->randomLetter . '.png',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert(array_merge($hardcodedData, $data));
    }
}
