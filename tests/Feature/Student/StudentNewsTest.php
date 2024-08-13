<?php

namespace Tests\Feature\Student;

use App\Models\Module;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentNewsTest extends TestCase
{
    use RefreshDatabase;
    public function testStudentCanViewNewsIndex()
    {
        $student = User::factory()->create(['user_type' => 'student']);
        $module = Module::factory()->create();
        
        $student->enrollments()->create([
            'module_id' => $module->module_id,
            'enrollment_date' => now()
        ]);
    
        News::factory()->count(3)->create(['module_id' => $module->module_id]);
    
        $response = $this->actingAs($student)->get(route('modules.student.news.index', ['module_id' => $module->module_id]));
    
        $response->assertStatus(200);
        $response->assertViewHas('newsItems');
        $response->assertViewHas('module');
    }
    
    public function testStudentCanViewSingleNewsItem()
    {
        $student = User::factory()->create(['user_type' => 'student']);
        $module = Module::factory()->create();
    
        $student->enrollments()->create([
            'module_id' => $module->module_id,
            'enrollment_date' => now()
        ]);
    
        $newsItem = News::factory()->create(['module_id' => $module->module_id]);
    
        $response = $this->actingAs($student)->get(route('modules.student.news.show', ['module_id' => $module->module_id, 'news' => $newsItem->news_id]));
    
        $response->assertStatus(200);
        $response->assertViewHas('newsItem');
        $response->assertViewHas('module');
    }
    
}