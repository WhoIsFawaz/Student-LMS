<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Sidebar extends Component
{
    public $universityName;
    public $logoLightUrl;
    public $logoDarkUrl;
    public $modules;
    public $userName;
    public $userProfileUrl;
    public $currentPage;
    public $currentModule;

    public function mount($currentPage, $currentModule = null)
    {
        abort_if(!Auth::user()?->isStudent(), 403);

        $university = University::firstOrFail();
        $this->universityName = $university->university_name ? $university->university_name : 'EduHub';
        $this->logoLightUrl = $university->logo ? Storage::url($university->logo) : '/images/icon-transparent.png';
        $this->logoDarkUrl = $university->logo ? Storage::url($university->logo) : '/images/icon-transparent.png';
        $this->modules = DB::table('modules')
            ->join('enrollments', 'modules.module_id', '=', 'enrollments.module_id')
            ->where('enrollments.user_id', Auth::user()->user_id)
            ->select('modules.module_name', 'modules.module_id')
            ->get();
        $this->userName = Auth::user()->first_name;
        $nameFirstChar = strtolower($this->userName[0]);
        $this->userProfileUrl = Storage::url(Auth::user()->profile_picture) ?? "images/default-profiles/{$nameFirstChar}.png";
        $this->currentPage = $currentPage;
        $this->currentModule = $currentModule;
    }

    public function placeholder()
    {
        return view('components.spinner');
    }
    
    public function render()
    {
        return view('livewire.student.sidebar');
    }
}