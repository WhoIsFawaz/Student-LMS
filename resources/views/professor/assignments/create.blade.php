<x-layout>
    <x-slot name="title">
        {{ __('Create Assignment') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleAssignment :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Create Assignment", 'currentModule' => $module_id])
        <div class="p-4">
            <form action="{{ route('modules.professor.assignments.store', $module_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="weightage">Weightage</label>
                    <input type="number" class="form-control" id="weightage" name="weightage" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" required>
                </div>
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" class="form-control-file" id="file" name="file">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</x-layout>
