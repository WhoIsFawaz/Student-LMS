<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleContent :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => 'Content', 'currentModuleId' => $module_id])
        <div class="p-4">
            <livewire:student.content-table :module_id=$module_id lazy>
        </div>
    </div>
</x-layout>
