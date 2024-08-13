<?php

namespace Tests\Feature\Professor;

use App\Models\Module;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorNewsTest extends TestCase
{
    use RefreshDatabase;

    public function testProfessorCanCreateNews()
    {
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();
        
        $professor->teaches()->create(['module_id' => $module->module_id]);

        $newsData = [
            'module_id' => $module->module_id,
            'news_title' => 'Test News Title',
            'news_description' => 'Test News Description',
        ];

        $response = $this->actingAs($professor)->post(route('modules.professor.news.store', ['module_id' => $module->module_id]), $newsData);

        $response->assertRedirect(route('modules.professor.news.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseHas('news', $newsData);
    }

    public function testProfessorCanEditNews()
    {
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();
        $news = News::factory()->create(['module_id' => $module->module_id]);

        $professor->teaches()->create(['module_id' => $module->module_id]);

        $newsData = [
            'news_title' => 'Updated News Title',
            'news_description' => 'Updated News Description',
        ];

        $response = $this->actingAs($professor)->patch(route('modules.professor.news.update', ['module_id' => $module->module_id, 'news' => $news->news_id]), $newsData);

        $response->assertRedirect(route('modules.professor.news.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseHas('news', array_merge(['news_id' => $news->news_id], $newsData));
    }

    public function testProfessorCanDeleteNews()
    {
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();
        $news = News::factory()->create(['module_id' => $module->module_id]);

        $professor->teaches()->create(['module_id' => $module->module_id]);

        $response = $this->actingAs($professor)->delete(route('modules.professor.news.destroy', ['module_id' => $module->module_id, 'news' => $news->news_id]));

        $response->assertRedirect(route('modules.professor.news.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseMissing('news', ['news_id' => $news->news_id]);
    }
}