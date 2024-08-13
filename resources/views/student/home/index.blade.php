<x-layout>
    <x-slot name="title">
        Home
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleHome :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Home", 'currentModuleId' => $module_id])
        <div class="p-4">
        </div>
    </div>
</x-layout>
