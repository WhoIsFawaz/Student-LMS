<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $moduleId = $request->route('module_id');
        $user = Auth::user();

        // Get user's enrollments and teaches directly from the model properties
        $enrollments = $user->enrollments;
        $teaches = $user->teaches;

        // Check if the user is a student enrolled in the module
        $isStudentEnrolled = $enrollments->contains('module_id', $moduleId);

        // Check if the user is a professor teaching the module
        $isProfessorTeaching = $teaches->contains('module_id', $moduleId);

        if (!$isStudentEnrolled && !$isProfessorTeaching) {
            // Redirect or abort with a 403 forbidden response if the user is neither a student nor a professor of the module
            return redirect(Auth::user()->user_type . '.dashboard')->with('error', 'You do not have access to this module.');
        }

        return $next($request);
    }
}