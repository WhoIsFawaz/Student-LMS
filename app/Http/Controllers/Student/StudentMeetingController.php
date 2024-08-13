<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Timeslot;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StudentMeetingController extends Controller
{

    public function index($module_id)
{
    $module = Module::findOrFail($module_id);

    $meetings = DB::table('meetings')
        ->join('users', 'meetings.user_id', '=', 'users.user_id')
        ->where('meetings.module_id', $module_id)
        ->get();

    return view('student.meetings.index', compact('module', 'meetings', 'module_id'));
}


    public function update(Request $request, $module_id, $meeting_id)
    {
        $meeting = Meeting::where('meeting_id', $meeting_id)->firstOrFail();

        // $meeting->is_booked = true;  // timeslot 
        $meeting->status = $request->input('status');
        $meeting->booked_by_user_id = auth()->id();
        $meeting->save();

        // dd($timeslot);
        return redirect()->route('modules.student.meetings.index', ['module_id' => $module_id])
            ->with('success', 'Meeting slot booked successfully!');
    }

    public function updateBooking(Request $request, $module_id, $meeting_id)
    {
        $meeting = Meeting::where('meeting_id', $meeting_id)->firstOrFail();

        // $meeting->is_booked = true;  // timeslot 
        $meeting->status = $request->input('status');
        $meeting->booked_by_user_id = null;
        $meeting->save();

        // dd($timeslot);
        return redirect()->route('modules.student.meetings.index', ['module_id' => $module_id])
            ->with('success', 'Meeting slot unbooked successfully!');
    }


}
