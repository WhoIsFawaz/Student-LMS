<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $modules = [];

        // List of unique course names
        $courseNames = [
            'Introduction to Computer Science',
            'Advanced Mathematics',
            'Fundamentals of Physics',
            'Organic Chemistry',
            'World History',
            'Modern Literature',
            'Psychology 101',
            'Principles of Economics',
            'Software Engineering',
            'Data Structures and Algorithms',
            'Calculus I',
            'Calculus II',
            'Linear Algebra',
            'Discrete Mathematics',
            'Introduction to Programming',
            'Object-Oriented Programming',
            'Operating Systems',
            'Database Management Systems',
            'Computer Networks',
            'Artificial Intelligence',
            'Machine Learning',
            'Data Science',
            'Big Data Analytics',
            'Cloud Computing',
            'Cybersecurity',
            'Human-Computer Interaction',
            'Software Testing',
            'Digital Logic Design',
            'Computer Architecture',
            'Microprocessor Systems',
            'Embedded Systems',
            'Mobile Application Development',
            'Web Development',
            'Game Development',
            'Computer Graphics',
            'Natural Language Processing',
            'Robotics',
            'Internet of Things',
            'Blockchain Technology',
            'Quantum Computing',
            'Renewable Energy Systems',
            'Environmental Science',
            'Biotechnology',
            'Genetics',
            'Molecular Biology',
            'Immunology',
            'Neuroscience',
            'Pharmacology',
            'Epidemiology',
            'Public Health',
            'Sociology',
            'Anthropology',
            'Political Science',
            'International Relations',
            'Law and Society',
            'Criminal Justice',
            'Forensic Science',
            'Psychiatry',
            'Clinical Psychology',
            'Developmental Psychology',
            'Educational Psychology',
            'Social Psychology',
            'Marketing',
            'Finance',
            'Accounting',
            'Management',
            'Entrepreneurship',
            'Human Resource Management',
            'Operations Management',
            'Business Analytics',
            'Supply Chain Management',
            'Information Systems',
            'Econometrics',
            'Macroeconomics',
            'Microeconomics',
            'Labor Economics',
            'Health Economics',
            'Urban Planning',
            'Architecture',
            'Interior Design',
            'Landscape Architecture',
            'Urban Design',
            'Civil Engineering',
            'Mechanical Engineering',
            'Electrical Engineering',
            'Chemical Engineering',
            'Materials Science',
            'Aeronautical Engineering',
            'Biomedical Engineering',
            'Nuclear Engineering',
            'Marine Engineering',
            'Agricultural Engineering',
            'Food Science',
            'Nutrition',
            'Sports Science',
            'Kinesiology',
            'Music Theory',
            'Music Performance',
            'Theater Arts',
            'Film Studies',
            'Art History',
            'Visual Arts',
            'Graphic Design'
        ];

        // Ensure course names are unique by using a set
        $uniqueCourseNames = array_unique($courseNames);

        // Faker-generated data with unique course names
        for ($i = 0; $i < 100; $i++) {
            $modules[] = [
                'module_name' => $uniqueCourseNames[$i],
                'module_code' => strtoupper($faker->bothify('???###')),
                'description' => $faker->sentence,
                'credits' => $faker->numberBetween(1, 5),
                'logo' => null, // Set logo to null
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert Faker-generated modules and get their IDs
        foreach ($modules as $module) {
            $moduleId = DB::table('modules')->insertGetId($module);
            $this->insertModuleFolders($moduleId);
        }
    }

    private function insertModuleFolders($moduleId)
    {
        $folders = ['Lecture', 'Tutorial', 'Practical'];

        foreach ($folders as $folder) {
            DB::table('module_folders')->insert([
                'folder_name' => $folder,
                'module_id' => $moduleId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
