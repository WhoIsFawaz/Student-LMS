<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Get user IDs, module IDs, and content IDs
        $userIds = DB::table('users')->pluck('user_id');
        $moduleIds = DB::table('modules')->pluck('module_id');
        $contentIds = DB::table('module_contents')->pluck('content_id');

        foreach ($userIds as $userId) {
            for ($i = 0; $i < 5; $i++) { // Create 5 favourite records per user
                DB::table('favourites')->insert([
                    'user_id' => $userId,
                    'module_id' => $faker->randomElement($moduleIds),
                    'content_id' => $faker->randomElement($contentIds),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
