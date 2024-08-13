<?php

namespace App\Http\Controllers\Professor;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Meeting;
use App\Models\Assignment;
use App\Models\Teaches;
use App\Http\Controllers\Controller;
use App\Models\User;

class ProfessorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch module IDs based on teaches table
        $moduleIds = Teaches::where('user_id', $user->user_id)->pluck('module_id');

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

        // Fetch meetings based on module IDs and professor ID
        $meetings = Meeting::whereIn('module_id', $moduleIds)
            ->where('user_id', $user->user_id)
            ->select('meeting_id as id', 'meeting_date as start', 'module_id', 'timeslot', 'booked_by_user_id')
            ->get()
            ->each(function($item) {
                $item->type = 'meeting';
            });

        // Merge assignments, quizzes, and meetings into events
        $events = $assignments->concat($quizzes)->concat($meetings);

        // Fetch module names and associate with events
        $moduleNames = Module::whereIn('module_id', $moduleIds)
            ->pluck('module_name', 'module_id');

        // Fetch student names and associate with meetings
        $studentIds = $meetings->pluck('booked_by_user_id')->unique();
        $students = User::whereIn('user_id', $studentIds)
            ->get(['user_id', 'first_name', 'last_name'])
            ->keyBy('user_id')
            ->map(function($student) {
                return $student->first_name . ' ' . $student->last_name;
            });

        // Append module name and student name to each event
        $events = $events->map(function ($event) use ($moduleNames, $students) {
            $moduleId = $event->module_id;
            $moduleName = $moduleNames[$moduleId] ?? 'Unknown Module';
            $event->module_name = $moduleName;

            if ($event->type === 'meeting') {
                $studentId = $event->booked_by_user_id;
                $studentName = $students[$studentId] ?? 'Yet to be booked';
                $event->student_name = $studentName;
            }

            return $event;
        });

        // Pass events to the view
        return view('professor.dashboard.index', compact('events'));
    }
}