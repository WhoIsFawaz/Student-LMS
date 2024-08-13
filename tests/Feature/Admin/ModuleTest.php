<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;

class ModuleTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanAddModule(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'user_type' => 'admin',
        ]);

        // Authenticate as the admin user
        $this->actingAs($admin);

        // Define module data
        $moduleData = [
            'module_name' => 'Test Module',
            'module_code' => 'TM101',
            'description' => 'This is a test module.',
            'credits' => 3,
            'logo' => 'test_logo.png',
        ];

        // Simulate adding a module through the Filament admin panel
        Livewire::test('App\Filament\Resources\ModuleResource\Pages\CreateModule')
            ->set('data.module_name', $moduleData['module_name'])
            ->set('data.module_code', $moduleData['module_code'])
            ->set('data.description', $moduleData['description'])
            ->set('data.credits', $moduleData['credits'])
            ->set('data.logo', $moduleData['logo'])
            ->call('create');

        // Verify if the module was added to the database
        $this->assertDatabaseHas('modules', $moduleData);
    }
}