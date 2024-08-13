<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Module;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    protected $model = Meeting::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'module_id' => Module::factory(),
            'meeting_date' => $this->faker->date,
            'timeslot' => $this->faker->randomElement(['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '17:00']),
            'status' => 'vacant',
        ];
    }
}