<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NavBarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $userModules = collect();

        if ($user) {
            if ($user->user_type == 'professor') {
                $userModules = DB::table('modules')
                    ->join('teaches', 'modules.module_id', '=', 'teaches.module_id')
                    ->where('teaches.user_id', $user->user_id)
                    ->select('modules.module_name', 'modules.module_id')
                    ->get();
            } elseif ($user->user_type == 'student') {
                $userModules = DB::table('modules')
                    ->join('enrollments', 'modules.module_id', '=', 'enrollments.module_id')
                    ->where('enrollments.user_id', $user->user_id)
                    ->select('modules.module_name', 'modules.module_id')
                    ->get();
            }
        }

        // Debug statement
        //dd('NavBarComposer called', $modules);

        $view->with('userModules', $userModules);
    }
}
