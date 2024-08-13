<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>
    
    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleQuiz :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Quizzes", 'currentModuleId' => $module_id])
        <div class="p-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('modules.professor.quizzes.create', ['module_id' => $module->module_id]) }}" class="btn btn-primary mb-4">Create New Quiz</a>

        @if($quizzes->isEmpty())
            <p>No quizzes found for this module.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->quiz_title }}</td>
                            <td>{{ $quiz->quiz_description }}</td>
                            <td>{{ $quiz->quiz_date }}</td>
                            <td>
                                <a href="{{ route('modules.professor.quizzes.show', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('modules.professor.quizzes.edit', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('modules.professor.quizzes.destroy', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout>
