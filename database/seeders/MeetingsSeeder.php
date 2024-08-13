<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MeetingsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];
        $batchSize = 100; // Set a batch size for inserts

        // Retrieve all module IDs and user IDs
        $moduleIds = DB::table('modules')->pluck('module_id')->toArray();
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        for ($i = 0; $i < 200; $i++) { // Assuming we seed 200 meetings
            $data[] = [
                'module_id' => $faker->randomElement($moduleIds), // Ensure module_id exists
                'user_id' => $faker->randomElement($userIds), // Ensure user_id exists
                'booked_by_user_id' => $faker->randomElement($userIds), // Ensure booked_by_user_id exists
                'meeting_date' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'timeslot' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s'),
                'status' => $faker->randomElement(['vacant', 'booked']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data in batches
            if (count($data) >= $batchSize) {
                DB::table('meetings')->insert($data);
                $data = []; // Reset data array
            }
        }

        // Insert any remaining data
        if (!empty($data)) {
            DB::table('meetings')->insert($data);
        }
    }
}
?>
