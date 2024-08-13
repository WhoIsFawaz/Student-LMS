<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class QuizQuestionsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all quizzes along with their module names
        $quizzes = DB::table('quiz')
            ->join('modules', 'quiz.module_id', '=', 'modules.module_id') // Assuming 'module_id' in quiz is related to modules.id
            ->get(['quiz.quiz_id', 'quiz.quiz_title as quiz_name', 'modules.module_name as module_name']);

        foreach ($quizzes as $quiz) {
            for ($i = 0; $i < 10; $i++) { // Assuming 10 random questions per quiz
                $option_a = $faker->text(50);
                $option_b = $faker->text(50);
                $option_c = $faker->text(50);
                $option_d = $faker->text(50);
                $correct_option = $faker->randomElement(['a', 'b', 'c', 'd']);

                $question = "In the context of the {$quiz->module_name} module and the {$quiz->quiz_name} quiz: " . $faker->sentence(10);

                $data[] = [
                    'quiz_id' => $quiz->quiz_id,
                    'question' => $question,
                    'option_a' => $option_a,
                    'option_b' => $option_b,
                    'option_c' => $option_c,
                    'option_d' => $option_d,
                    'correct_option' => $correct_option,
                    'marks' => $faker->numberBetween(1, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('quiz_questions')->insert($data);
    }
}
?>
