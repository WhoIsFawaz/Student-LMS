<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuizSubmissionsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $batchSize = 100; // Set a batch size for inserts
        $data = [];

        // Retrieve all quiz questions along with their options
        $quizQuestions = DB::table('quiz_questions')->get(['quiz_questions_id']);
        
        // Retrieve all user IDs (assuming there are users in the users table)
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        foreach ($quizQuestions as $question) {
            // Randomly select an option key
            $selectedOption = $faker->randomElement(['a', 'b', 'c', 'd']);

            $data[] = [
                'quiz_questions_id' => $question->quiz_questions_id,
                'user_id' => $faker->randomElement($userIds),
                'submission_answer' => $selectedOption,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data in batches
            if (count($data) >= $batchSize) {
                DB::table('quiz_submissions')->insert($data);
                $data = []; // Reset data array
            }
        }

        // Insert any remaining data
        if (!empty($data)) {
            DB::table('quiz_submissions')->insert($data);
        }
    }
}
?>
