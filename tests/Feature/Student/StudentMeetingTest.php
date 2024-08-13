<?php


namespace Tests\Feature\Student;

use App\Models\Module;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentMeetingTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_meetings()
    {
        $student = User::factory()->create(['user_type' => 'student']);
        $module = Module::factory()->create();
        $meetings = Meeting::factory()->count(3)->create(['module_id' => $module->module_id]);

        // Associate the student with the module using the enrollments table
        $student->enrollments()->create(['module_id' => $module->module_id, 'enrollment_date' => now()]);

        $response = $this->actingAs($student)->get(route('modules.student.meetings.index', ['module_id' => $module->module_id]));

        $response->assertStatus(200);
        $response->assertViewHas('meetings');
    }

    public function test_student_can_book_meeting()
    {
        $student = User::factory()->create(['user_type' => 'student']);
        $module = Module::factory()->create();
        $meeting = Meeting::factory()->create(['module_id' => $module->module_id, 'status' => 'vacant']);

        // Associate the student with the module using the enrollments table
        $student->enrollments()->create(['module_id' => $module->module_id, 'enrollment_date' => now()]);

        $response = $this->actingAs($student)->patch(route('modules.student.meetings.update', [
            'module_id' => $module->module_id,
            'meeting' => $meeting->meeting_id,
        ]), [
            'status' => 'booked'
        ]);

        $response->assertRedirect(route('modules.student.meetings.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseHas('meetings', [
            'meeting_id' => $meeting->meeting_id,
            'status' => 'booked',
            'booked_by_user_id' => $student->user_id,
        ]);
    }

    public function test_student_can_unbook_meeting()
    {
        $student = User::factory()->create(['user_type' => 'student']);
        $module = Module::factory()->create();
        $meeting = Meeting::factory()->create(['module_id' => $module->module_id, 'status' => 'booked', 'booked_by_user_id' => $student->user_id]);

        // Associate the student with the module using the enrollments table
        $student->enrollments()->create(['module_id' => $module->module_id, 'enrollment_date' => now()]);

        $response = $this->actingAs($student)->patch(route('modules.student.meetings.updateBooking', [
            'module_id' => $module->module_id,
            'meeting' => $meeting->meeting_id,
        ]), [
            'status' => 'vacant'
        ]);

        $response->assertRedirect(route('modules.student.meetings.index', ['module_id' => $module->module_id]));
        $this->assertDatabaseHas('meetings', [
            'meeting_id' => $meeting->meeting_id,
            'status' => 'vacant',
            'booked_by_user_id' => null,
        ]);
    }
}