<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnsureUserIsProfessor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('EnsureUserIsProfessor middleware triggered.');

        if (Auth::check() && Auth::user()->user_type === 'professor') {
            Log::info('User is a professor.');
            return $next($request);
        }

        Log::warning('Access denied for user: ' . Auth::user()->id);
        return redirect('/')->with('error', 'Access Denied.');    }
}
