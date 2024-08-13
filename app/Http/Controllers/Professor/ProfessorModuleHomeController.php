<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;

class ProfessorModuleHomeController extends Controller
{
    public function index($module_id)
    {
        $user = auth()->user();
        return view('professor.home.index', compact('module_id'));
    }
}