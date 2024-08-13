<?php

namespace App\Livewire\Professor;

use Livewire\Component;

class ModuleHeader extends Component
{
    public $currentPage;
    public $moduleName;
    public $moduleCode;

    public function mount($currentPage, $currentModuleId = "")
    {
        $this->currentPage = $currentPage;
        if ($currentModuleId != "") {
            $module = \App\Models\Module::find($currentModuleId);
            $this->moduleName = $module->module_name;
            $this->moduleCode = $module->module_code;
        } else {
            $this->moduleName = "";
            $this->moduleCode = "";
        }
    }
    
    public function render()
    {
        return view('livewire.professor.module-header', [
            'currentPage' => $this->currentPage,
            'moduleName' => $this->moduleName,
            'moduleCode' => $this->moduleCode,
        ]);
    }
}
