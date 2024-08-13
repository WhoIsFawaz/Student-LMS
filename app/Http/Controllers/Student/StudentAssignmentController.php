<?php

namespace App\Http\Controllers\Student;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentAssignmentController extends Controller
{
    public function index($module_id)
    {
        return view('student.assignments.index', compact('module_id'));
    }
    public function show($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        $submitted = Assignment::where('assignment_id', $assignment_id)
            ->with([
                'submissions' => fn ($query) => $query
                    ->where('user_id', '=', Auth::user()->user_id)
            ])
            ->get();

        abort_if($assignment->module_id != $module_id, 403);

        return view('student.assignments.show', compact('assignment', 'module_id', 'submitted'));
    }

    public function submit(Request $request, $module_id, $assignment_id)
    {
        // Log the request data for debugging
        Log::info('Form Data:', $request->all());

        $request->validate([
            'description' => 'required|string',
            'files.*' => 'required|file|max:999999',
        ]);

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('submissions', $fileName, 'public');
                $filePaths[] = $filePath;
            }
        }

        AssignmentSubmission::create([
            'assignment_id' => $assignment_id,
            'user_id' => Auth::id(),
            'submission_description' => $request->description,
            'submission_files' => json_encode($filePaths),
            'submission_date' => now(),
        ]);

        return redirect()->route('modules.student.assignments.index', [$module_id, $assignment_id])->with('success', 'Assignment submitted successfully.');;
    }

    public function download($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);

        if (!Storage::disk('public')->exists($assignment->file_path)) {
            return redirect()->back()->with('error', 'File does not exist.');
        }

        return Storage::disk('public')->download($assignment->file_path);
    }
}
