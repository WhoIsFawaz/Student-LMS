<?php

namespace Tests\Feature\Professor;

use App\Models\Meeting;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorMeetingTest extends TestCase
{
    use RefreshDatabase;

    public function test_professor_can_create_meeting()
    {
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();

        // Associate the professor with the module using the teaches table
        \DB::table('teaches')->insert([
            'user_id' => $professor->user_id,
            'module_id' => $module->module_id,
        ]);

        $meetingData = [
            'meeting_date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '09:00',
        ];

        $response = $this->actingAs($professor)->post(route('modules.professor.meetings.store', ['module_id' => $module->module_id]), $meetingData);

        $response->assertRedirect(route('modules.professor.meetings.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseHas('meetings', [
            'module_id' => $module->module_id,
            'meeting_date' => $meetingData['meeting_date'],
            'timeslot' => $meetingData['time'],
        ]);
    }

    public function test_professor_can_edit_meeting()
    {
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();
        $meeting = Meeting::factory()->create(['module_id' => $module->module_id, 'user_id' => $professor->user_id]);

        // Associate the professor with the module using the teaches table
        \DB::table('teaches')->insert([
            'user_id' => $professor->user_id,
            'module_id' => $module->module_id,
        ]);

        $meetingData = [
            'meeting_date' => now()->addDays(7)->format('Y-m-d'),
            'timeslot' => '10:00',
        ];

        $response = $this->actingAs($professor)->put(route('modules.professor.meetings.update', ['module_id' => $module->module_id, 'meeting' => $meeting->meeting_id]), $meetingData);

        $response->assertRedirect(route('modules.professor.meetings.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseHas('meetings', [
            'meeting_id' => $meeting->meeting_id,
            'meeting_date' => $meetingData['meeting_date'],
            'timeslot' => $meetingData['timeslot'],
        ]);
    }

    public function test_professor_can_delete_meeting()
    {
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();
        $meeting = Meeting::factory()->create(['module_id' => $module->module_id, 'user_id' => $professor->user_id]);

        // Associate the professor with the module using the teaches table
        \DB::table('teaches')->insert([
            'user_id' => $professor->user_id,
            'module_id' => $module->module_id,
        ]);

        $response = $this->actingAs($professor)->delete(route('modules.professor.meetings.destroy', ['module_id' => $module->module_id, 'meeting' => $meeting->meeting_id]));

        $response->assertRedirect(route('modules.professor.meetings.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseMissing('meetings', [
            'meeting_id' => $meeting->meeting_id,
        ]);
    }
}