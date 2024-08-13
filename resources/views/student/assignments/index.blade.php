<x-app-layout>
    <x-slot name="title">
        {{ __('Assignments') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleAssignment :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Assignments", 'currentModuleId' => $module_id])
        <div class="p-4">
            <livewire:student.assignment-table :module_id=$module_id lazy>
        </div>
    </div>
</x-app-layout>