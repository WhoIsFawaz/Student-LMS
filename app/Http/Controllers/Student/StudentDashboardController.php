<?php

namespace App\Http\Controllers\Student;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Meeting;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch module IDs based on user's enrollments
        $moduleIds = Enrollment::where('user_id', $user->user_id)->pluck('module_id');

        // Fetch assignments and quizzes based on module IDs
        $assignments = Assignment::whereIn('module_id', $moduleIds)
            ->select('assignment_id as id', 'title', 'due_date as start', 'module_id')
            ->get()
            ->each(function($item) {
                $item->type = 'assignment';
            });

        $quizzes = Quiz::whereIn('module_id', $moduleIds)
            ->select('quiz_id as id', 'quiz_title as title', 'quiz_date as start', 'module_id')
            ->get()
            ->each(function($item) {
                $item->type = 'quiz';
            });

        // Fetch meetings based on module IDs and user ID
        $meetings = Meeting::whereIn('module_id', $moduleIds)
            ->where('booked_by_user_id', $user->user_id)
            ->select('meeting_id as id', 'meeting_date as start', 'module_id', 'timeslot', 'user_id')
            ->get()
            ->each(function($item) {
                $item->type = 'meeting';
            });

        // Merge assignments, quizzes, and meetings into events
        $events = $assignments->concat($quizzes)->concat($meetings);

        // Fetch module names and associate with events
        $moduleNames = Module::whereIn('module_id', $moduleIds)
            ->pluck('module_name', 'module_id');

        // Fetch professor names and associate with meetings
        $professorIds = $meetings->pluck('user_id')->unique();
        $professors = User::whereIn('user_id', $professorIds)
            ->get(['user_id', 'first_name', 'last_name'])
            ->keyBy('user_id')
            ->map(function($professor) {
                return $professor->first_name . ' ' . $professor->last_name;
            });

        // Append module name and professor name to each event
        $events = $events->map(function ($event) use ($moduleNames, $professors) {
            $moduleId = $event->module_id;
            $moduleName = $moduleNames[$moduleId] ?? 'Unknown Module';
            $event->module_name = $moduleName;

            if ($event->type === 'meeting') {
                $professorId = $event->user_id;
                $professorName = $professors[$professorId] ?? 'Unknown Professor';
                $event->professor_name = $professorName;
            }

            return $event;
        });

        // Pass events to the view
        return view('student.dashboard.index', compact('events'));
    }
}