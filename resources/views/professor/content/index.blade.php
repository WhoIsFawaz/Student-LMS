<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleContent :currentModule="$module_id" />

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => 'Content', 'currentModuleId' => $module_id])

        <div class="p-4">
            <div class="d-flex align-items-center mb-3">
                <ul class="nav nav-pills flex-scroll-x gap-2 p-1 small bg-body-secondary rounded-5 me-3"
                    style="width: fit-content;" id="content-tab" role="tablist">
                    @foreach ($folders as $index => $folder)
                        <li class="nav-item d-inline-block" role="presentation">
                            <a class="nav-link rounded-5 @if ($index == 0) active @endif"
                                id="tab-{{ $folder->module_folder_id }}" data-bs-toggle="tab"
                                href="#folder-{{ $folder->module_folder_id }}" role="tab"
                                aria-controls="folder-{{ $folder->module_folder_id }}"
                                aria-selected="true">{{ $folder->folder_name }}</a>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('modules.professor.folder.create', ['module_id' => $module_id]) }}"
                    class="btn btn-primary">+ Add Folder</a>
            </div>
            <div class="tab-content" id="contentTabsContent">
                @foreach ($folders as $index => $folder)
                    <div class="tab-pane fade @if ($index == 0) show active @endif"
                        id="folder-{{ $folder->module_folder_id }}" role="tabpanel"
                        aria-labelledby="tab-{{ $folder->module_folder_id }}">
                        <div class="d-flex mb-3">
                            <a href="{{ route('modules.professor.folder.edit', ['module_id' => $module_id, 'folder' => $folder->module_folder_id]) }}"
                                class="btn btn-outline-warning btn-sm me-2"><i class="bi bi-pencil"></i> Edit Folder</a>
                            <form
                                action="{{ route('modules.professor.folder.destroy', ['module_id' => $module_id, 'folder' => $folder->module_folder_id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete Folder</button>
                            </form>
                        </div>
                        <div class="mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Time Uploaded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($folder->contents as $content)
                                        <tr>
                                            <td><a
                                                    href="{{ route('modules.professor.content.edit', ['module_id' => $module_id, 'content' => $content->content_id]) }}">{{ $content->title }}</a>
                                            </td>
                                            <td>{{ $content->created_at->format('h:iA, d M') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('modules.professor.content.create', ['module_id' => $module_id]) }}"
                class="btn btn-primary mt-3">+ Add Content</a>
        </div>
    </div>
</x-layout>
