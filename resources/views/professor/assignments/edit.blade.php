<x-layout>
    <x-slot name="title">
        {{ __('Edit Assignments') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleAssignment :currentModule=$module_id>

    <div class="container mt-5">
        @livewire('professor.module-header', ['currentPage' => $assignment->title, 'currentModuleId' => $module_id])
        <form action="{{ route('modules.professor.assignments.update', [$module_id, $assignment->assignment_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $assignment->title }}" required>
            </div>
            <div class="form-group">
                <label for="weightage">Weightage</label>
                <input type="text" class="form-control" id="weightage" name="weightage" value="{{ $assignment->weightage }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $assignment->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $assignment->due_date }}" required>
            </div>
            <div class="form-group">
                <label for="file">Upload File</label>
                <input type="file" class="form-control" id="file" name="file">
                @if($assignment->file_path)
                    <p><strong>Current File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">{{ basename($assignment->file_path) }}</a></p>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update Assignment</button>
        </form>
    </div>
</x-app-layout>
