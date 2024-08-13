<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UniversitySeeder::class,
            ModuleSeeder::class,
            ModuleContentSeeder::class,
            EnrollmentSeeder::class,
            FavouriteSeeder::class,
            TeachesSeeder::class,
            AdminSeeder::class,
            AssignmentSeeder::class,
            AssignmentSubmissionsSeeder::class,
            QuizSeeder::class,
            QuizQuestionsSeeder::class,
            QuizAttemptSeeder::class,
            QuizSubmissionsSeeder::class,
            MeetingsSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
