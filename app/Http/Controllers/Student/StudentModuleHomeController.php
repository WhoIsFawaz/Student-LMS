<?php

namespace App\Http\Controllers\Student;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StudentModuleHomeController extends Controller
{
    public function index($module_id)
    {
        $user = auth()->user();
        return view('student.home.index', compact('module_id'));
    }
}