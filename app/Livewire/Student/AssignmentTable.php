<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Assignment;
use Livewire\Attributes\Renderless;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;

class AssignmentTable extends Component
{
    public $module_id;
    public $currentFolder = 0;
    public $pending;
    public $submitted;
    public $search = '';
    public $sort = 'latest';
    public $sortColumn = 'due_date';
    public $sortOrder = 'desc';

    public function mount($module_id)
    {
        $this->module_id = $module_id;
    }

    public function placeholder()
    {
        return view('components.spinner');
    }

    #[Renderless] 
    public function updateCurrentFolder($folder_id)
    { 
        $this->currentFolder = $folder_id;
    }

    public function updateSort($sort)
    {
        switch ($sort) {
            case 'title_asc':
                $this->sortColumn = 'title';
                $this->sortOrder = 'asc';
                $this->sort = 'title_desc';
                break;
            case 'title_desc':
                $this->sortColumn = 'title';
                $this->sortOrder = 'desc';
                $this->sort = 'title_asc';
                break;
            case 'earliest':
                $this->sortColumn = 'due_date';
                $this->sortOrder = 'asc';
                $this->sort = 'latest';
                break;
            case 'latest':
                $this->sortColumn = 'due_date';
                $this->sortOrder = 'desc';
                $this->sort = 'earliest';
                break;
            default:
                $this->sortColumn = 'due_date';
                $this->sortOrder = 'desc';
                $this->sort = 'latest';
        }
    }

    public function render()
    {
        $this->pending = Assignment::where('module_id', $this->module_id)
            ->where('title', 'like', '%'.$this->search.'%')
            ->whereDoesntHave('submissions', function($query) {
                $query->where('user_id', '=', Auth::user()->user_id);
            })
            ->orderBy($this->sortColumn, $this->sortOrder)
            ->get();

        $this->submitted = Assignment::where('module_id', $this->module_id)
            ->where('title', 'like', '%'.$this->search.'%')
            ->whereHas('submissions', function($query) {
                $query->where('user_id', '=', Auth::user()->user_id);
            })
            ->orderBy($this->sortColumn, $this->sortOrder)
            ->get();
        
        return view('livewire.student.assignment-table');
    }
}
