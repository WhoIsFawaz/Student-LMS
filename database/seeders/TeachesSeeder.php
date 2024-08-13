<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TeachesSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */

    public function run(): void
    {
        // Define professor-to-module assignments
        $assignments = [
            'caoqi@eduhub.com' => [1, 2, 4, 5], 
            'binder@eduhub.com' => [7, 6, 9], 
            'nelson.mandela@eduhub.com' => [5, 6, 3,8], // Module IDs that Nelson Mandela teaches
            'vignesh.bala@eduhub.com' => [3, 7,10],
            'abdul.hakam@eduhub.com' => [6, 8, 9],
        ];

        // Get professor user IDs with email as a key
        $professorEmails = DB::table('users')
                             ->where('user_type', 'professor')
                             ->pluck('user_id', 'email');

        // Iterate over each assignment and insert into the database
        foreach ($assignments as $email => $modules) {
            $professorId = $professorEmails[$email] ?? null;
            if ($professorId) {

                foreach ($modules as $moduleId) {
                    DB::table('teaches')->insert([
                        'user_id' => $professorId,
                        'module_id' => $moduleId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
