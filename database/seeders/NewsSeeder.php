<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $data = [];

        // Retrieve all modules
        $modules = DB::table('modules')->get(['module_id', 'module_name']);

        foreach ($modules as $module) {
            $data[] = [
                'module_id' => $module->module_id,
                'news_title' => "Update on " . $module->module_name,
                'news_description' => $faker->paragraph . " related to " . $module->module_name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('news')->insert($data);
    }
}
?>
