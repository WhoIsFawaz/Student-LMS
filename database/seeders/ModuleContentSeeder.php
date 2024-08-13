<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ModuleContentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all module folder IDs and their corresponding module IDs
        $moduleFolders = DB::table('module_folders')
            ->join('modules', 'module_folders.module_id', '=', 'modules.module_id')
            ->get(['module_folders.module_folder_id', 'modules.module_name']);

        for ($i = 0; $i < 500; $i++) { // Assuming we seed 500 module contents
            $moduleFolder = $faker->randomElement($moduleFolders); // Get a random module folder
            
            $data[] = [
                'module_folder_id' => $moduleFolder->module_folder_id, // Ensure module_folder_id exists
                'title' => substr('Content for ' . $moduleFolder->module_name . ': ' . $faker->sentence, 0, 100),
                'description' => 'This content for ' . $moduleFolder->module_name . ' includes ' . $faker->paragraph,
                'file_path' => $faker->randomElement(['/seeder-media/example-content-1.pdf', '/seeder-media/example-content-2.pdf', '/seeder-media/example-content-3.JPG']),
                'upload_date' => $faker->dateTimeBetween('-1 year', 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('module_contents')->insert($data);
    }
}
