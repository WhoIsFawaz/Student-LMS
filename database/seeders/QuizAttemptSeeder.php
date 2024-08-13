<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuizAttemptSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all quiz IDs and user IDs
        $quizIds = DB::table('quiz')->pluck('quiz_id')->toArray();
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        for ($i = 0; $i < 500; $i++) { // Assuming we seed 500 quiz attempts
            $data[] = [
                'quiz_id' => $faker->randomElement($quizIds), // Ensure quiz_id exists
                'user_id' => $faker->randomElement($userIds), // Ensure user_id exists
                'total_marks' => $faker->numberBetween(0, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('quiz_attempt')->insert($data);
    }
}
