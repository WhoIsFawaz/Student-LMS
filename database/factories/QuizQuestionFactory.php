<?php

namespace Database\Factories;

use App\Models\QuizQuestion;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition()
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question' => $this->faker->sentence,
            'option_a' => $this->faker->word,
            'option_b' => $this->faker->word,
            'option_c' => $this->faker->word,
            'option_d' => $this->faker->word,
            'correct_option' => 'A',
            'marks' => $this->faker->numberBetween(1, 10),
        ];
    }
}