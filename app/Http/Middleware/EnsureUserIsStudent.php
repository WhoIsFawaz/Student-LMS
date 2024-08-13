<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserIsStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('EnsureUserIsStudent middleware triggered.');

        if (Auth::check() && Auth::user()->user_type === 'student') {
            Log::info('User is a student.');
            return $next($request);
        }

        Log::warning('Access denied for user: ' . Auth::user()->id);
        return redirect('/')->with('error', 'Access Denied.');
    }
}
