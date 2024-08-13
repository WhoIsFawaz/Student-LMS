<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleContent :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Content", 'currentModuleId' => $module_id])
        <div class="p-4">
            <p>{{ $content->description }}</p>
            @if(strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) == 'PDF')
            <div class="pdf-viewer">
                <embed src="{{ route('modules.professor.content.view', ['module_id' => $module->module_id, 'content_id' => $content->content_id]) }}" width="100%" height="1200px" type="application/pdf">
            </div>
            @elseif(strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) == 'MP4')
            <video width="100%" height="500px" controls>
                <source src="{{ Storage::url($content->file_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            @endif
            <p><strong>Type:</strong> {{ strtoupper(pathinfo($content->file_path, PATHINFO_EXTENSION)) }}</p>
            <p><strong>Time Uploaded:</strong> {{ $content->created_at->format('h:iA, d M Y') }}</p>

            <a href="{{ route('modules.professor.content.edit', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}"
                class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('modules.professor.content.destroy', ['module_id' => $module->module_id, 'content' => $content->content_id]) }}"
                method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</x-layout>
