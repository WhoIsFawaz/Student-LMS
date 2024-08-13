<x-layout>
    <x-slot name="title">
        {{ __('Create Content') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleContent :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Create Content", 'currentModuleId' => $module_id])
        <div class="p-4">
            <form action="{{ route('modules.professor.content.store', ['module_id' => $module->module_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="module_folder_id">Folder</label>
                    <select class="form-control" id="module_folder_id" name="module_folder_id" required>
                        @foreach ($folders as $folder)
                            <option value="{{ $folder->module_folder_id }}">{{ $folder->folder_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="title">Content Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="file_path">Upload File</label>
                    <input type="file" class="form-control" id="file_path" name="file_path">
                </div>
                <button type="submit" class="btn btn-primary">Create Content</button>
            </form>
        </div>
    </div>
</x-layout>
