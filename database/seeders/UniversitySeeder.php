<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('universities')->insert([
            'university_name' => 'Singapore Institute of Technology',
            'domain' => 'https://www.singaporetech.edu.sg/',
            'logo' => '/seeder-media/sit-light-logo.png', // Use a placeholder or actual logo path
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
