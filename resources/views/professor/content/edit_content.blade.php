<x-layout>
    <x-slot name="title">
        {{ __('Edit Content') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleContent :currentModule=$module_id>

        <div class="viewport-container container-fluid p-0">
            @livewire('professor.module-header', ['currentPage' => 'Edit Content', 'currentModuleId' => $module_id])
            <div class="p-4">
                <form
                    action="{{ route('modules.professor.content.update', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="module_folder_id">Folder</label>
                        <select class="form-control" id="module_folder_id" name="module_folder_id" required>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder->module_folder_id }}"
                                    {{ $folder->module_folder_id == $content->module_folder_id ? 'selected' : '' }}>
                                    {{ $folder->folder_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="title">Content Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $content->title }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $content->description }}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="file_path">Upload New File (Optional)</label>
                        <input type="file" class="form-control" id="file_path" name="file_path">
                    </div>
                    <div class="d-inline-block gap-4">
                        <form
                            action="{{ route('modules.professor.content.destroy', ['module_id' => $module_id, 'content' => $content->content_id]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i>  Delete</button>
                        </form>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>  Save</button>
                    </div>
                </form>
            </div>
        </div>
</x-layout>
