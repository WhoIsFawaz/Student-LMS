<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Module;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition()
    {
        return [
            'module_id' => Module::factory(),
            'user_id' => User::factory(),
            'enrollment_date' => $this->faker->date(), // Provide a date value
        ];
    }
}