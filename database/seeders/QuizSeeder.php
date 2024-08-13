<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all module IDs
        $modules = DB::table('modules')->get(['module_id', 'module_name']);
        
        for ($i = 0; $i < 200; $i++) { // Assuming we seed 200 quizzes
            $module = $faker->randomElement($modules); // Get a random module
            
            $data[] = [
                'module_id' => $module->module_id,
                'quiz_title' => 'Quiz for ' . $module->module_name . ': ' . $faker->sentence,
                'quiz_description' => 'This quiz for ' . $module->module_name . ' covers ' . $faker->sentence,
                'quiz_date' => Carbon::createFromTimestamp($faker->dateTimeBetween('now', '+1 year')->getTimestamp()),
                'duration' => $faker->numberBetween(30, 120), // Duration in minutes
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('quiz')->insert($data);
    }
}
