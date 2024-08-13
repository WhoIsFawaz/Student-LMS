<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'module_id' => Module::factory(),
            'quiz_title' => $this->faker->sentence,
            'quiz_description' => $this->faker->paragraph,
            'quiz_date' => $this->faker->dateTime,
            'duration' => $this->faker->numberBetween(30, 120),
        ];
    }
}