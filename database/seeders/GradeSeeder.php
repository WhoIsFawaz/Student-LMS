<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GradesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all assignment IDs and user IDs
        $assignmentIds = DB::table('assignments')->pluck('assignment_id')->toArray();
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        for ($i = 0; $i < 1000; $i++) { // Assuming we seed 1000 grades
            $data[] = [
                'assignment_id' => $faker->randomElement($assignmentIds), // Ensure assignment_id exists
                'user_id' => $faker->randomElement($userIds), // Ensure user_id exists
                'grade' => $faker->randomElement(['A', 'B', 'C', 'D', 'F']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('grades')->insert($data);
    }
}
