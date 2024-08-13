<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@eduhub.com',
            'date_of_birth' => '1996-07-11',
            'password' => Hash::make('password'), // Use a secure password
            'user_type' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
