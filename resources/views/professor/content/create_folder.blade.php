<x-layout>
    <x-slot name="title">
        {{ __('Create Folder') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleContent :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Create Content Folder", 'currentModuleId' => $module_id])
        <div class="p-4">
            <form action="{{ route('modules.professor.folder.store', ['module_id' => $module->module_id]) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="folder_name">Folder Name</label>
                    <input type="text" class="form-control" id="folder_name" name="folder_name" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Folder</button>
            </form>
        </div>
    </div>
</x-layout>
