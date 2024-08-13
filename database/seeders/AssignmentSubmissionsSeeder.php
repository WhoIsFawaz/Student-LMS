<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AssignmentSubmissionsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all assignment IDs and user IDs
        $assignments = DB::table('assignments')->get(['assignment_id', 'title']);
        $userIds = DB::table('users')->pluck('user_id')->toArray(); // Adjusted to match 'id' column in users table
        
        // Define some common file extensions
        $fileExtensions = ['pdf', 'docx', 'pptx', 'xlsx', 'jpg', 'png', 'txt'];

        for ($i = 0; $i < 1000; $i++) { // Assuming we seed 1000 assignment submissions
            $assignment = $faker->randomElement($assignments); // Get a random assignment
            
            // Generate a filename based on the assignment title
            $filename = $faker->randomElement(['/seeder-media/example-assignment-1.pdf', '/seeder-media/example-assignment-2.JPG']);

            $fileDetails = [
                'filename' => pathinfo($filename, PATHINFO_BASENAME),
                'path' => $filename, // Assuming files are uploaded to an 'uploads' directory
                'size' => $faker->numberBetween(1000, 1000000), // Random file size in bytes
                'type' => pathinfo($filename, PATHINFO_EXTENSION) // File type based on the extension
            ];

            $data[] = [
                'assignment_id' => $assignment->assignment_id, // Ensure assignment_id exists
                'user_id' => $faker->randomElement($userIds), // Ensure user_id exists
                'submission_description' => $faker->text(500), // Ensure the description fits within the varchar(500) limit
                'submission_files' => json_encode($fileDetails), // JSON encode the file details
                'submission_date' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s'),
                'grade' => $faker->randomElement(['A', 'B', 'C', 'D', 'F']), // Ensure the grade fits within varchar(255)
                'feedback' => $faker->text, // Feedback can be long as it is text
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('assignment_submissions')->insert($data);
    }
}
?>
