<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'module_name' => $this->faker->word,
            'module_code' => strtoupper($this->faker->bothify('??###')),
            'description' => $this->faker->sentence,
            'credits' => $this->faker->numberBetween(1, 10),
            'logo' => $this->faker->imageUrl,
        ];
    }
}