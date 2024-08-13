<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProfessorMeetingController extends Controller
{
    public function index($module_id)
    {
        $module = Module::findOrFail($module_id);

        $meetings = DB::table('meetings')
            ->join('users as professor', 'meetings.user_id', '=', 'professor.user_id') // Alias for professor
            ->leftJoin('users as student', 'meetings.booked_by_user_id', '=', 'student.user_id') // Alias for student
            ->select(
                'meetings.*',
                'professor.first_name as professor_first_name', // Professor's first name
                'professor.last_name as professor_last_name',   // Professor's last name
                'student.first_name as student_first_name',     // Student's first name
                'student.last_name as student_last_name'        // Student's last name
            )
            ->where('meetings.module_id', $module_id)
            ->where('meetings.user_id', auth()->id())
            ->get();

        // dd($meetings);
        return view('professor.meetings.index', compact('module', 'meetings', 'module_id'));
    }


    public function create($module_id)
    {
        $availableMeetings = Meeting::where('status', 0)->get();
        $times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '17:00'];
        $module = Module::findOrFail($module_id);

        return view('professor.meetings.create', compact('availableMeetings', 'times', 'module_id', 'module'));
    }

    public function store(Request $request, $module_id)
    {

        $validatedData = $request->validate([
            'meeting_date' => 'required|date',  // Ensuring that a valid date is provided for the meeting
            'time' => 'required|in:09:00,10:00,11:00,12:00,13:00,14:00,15:00,17:00',  // Ensuring the time is within the specified valid times
        ]);

        // Create a new meeting using the timeslot and module information
        $newMeeting = Meeting::create([
            'user_id' => auth()->id(),
            'module_id' => $module_id,
            'meeting_date' => $request->meeting_date,
            'timeslot' => $request->time,
            'status' => 'pending', // Default status
        ]);
        return redirect()->route('modules.professor.meetings.index', ['module_id' => $module_id])->with('success', 'Meeting created successfully');
    }

    public function destroy($module_id, $meeting_id)
    {
        $meeting = Meeting::findOrFail($meeting_id);
        $meeting->delete();

        return redirect()->route('modules.professor.meetings.index', $module_id)->with('success', 'Meeting deleted successfully');
    }


    public function edit($module_id, $meeting_id)
    {
        $meeting = Meeting::findOrFail($meeting_id);
        $module = Module::findOrFail($module_id);
        $times = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '17:00'];

        return view('professor.meetings.edit', compact('meeting', 'module', 'times', 'module_id'));
    }



    public function update(Request $request, $module_id, $meeting_id)
    {
        $validated = $request->validate([
            'meeting_date' => 'required|date',
            'timeslot' => 'required',
        ]);

        $meeting = Meeting::findOrFail($meeting_id);
        $meeting->update($validated);

        return redirect()->route('modules.professor.meetings.index', ['module_id' => $module_id])->with('success', 'Meeting created successfully');
    }



}
