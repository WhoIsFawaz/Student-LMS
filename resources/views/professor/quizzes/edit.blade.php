<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleQuiz :currentModule=$module_id>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Quiz for Module: ') }}{{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Edit Quiz", 'currentModuleId' => $module_id])
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

        <form id="quiz-form" action="{{ route('modules.professor.quizzes.update', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $quiz->quiz_title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description*</label>
                <textarea class="form-control" id="description" name="description" required>{{ $quiz->quiz_description }}</textarea>
            </div>
            <div class="form-group">
                <label for="datetime">Date and Time*</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="{{ $quiz->quiz_date }}" required>
            </div>
            <div>
                <label for="duration">Duration (in minutes):</label>
                <input type="number" class="form-control" id="duration" name="duration" value="{{ $quiz->duration }}" required>
            </div>

            <div id="questions-container">
                @foreach($quiz->questions as $index => $question)
                    <div class="question-group" data-index="{{ $index }}">
                        <hr>
                        <div class="form-group">
                            <label class="question-label" for="questions[{{ $index }}]">Question {{ $index + 1 }}</label>
                            <input type="text" class="form-control" name="questions[{{ $index }}]" value="{{ $question->question }}" required>
                        </div>
                        <div class="form-group">
                            <label for="marks[{{ $index }}]">Marks*</label>
                            <input type="number" class="form-control" name="marks[{{ $index }}]" value="{{ $question->marks }}" required>
                        </div>
                        <div class="form-group">
                            <label>Options</label>
                            <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_a }}" required>
                            <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_b }}" required>
                            <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_c }}" required>
                            <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_d }}" required>
                        </div>
                        <div class="form-group">
                            <label for="correct_options[{{ $index }}]">Correct Option*</label>
                            <select class="form-control" name="correct_options[{{ $index }}]" required>
                                <option value="A" {{ $question->correct_option == 'A' ? 'selected' : '' }}>Option A</option>
                                <option value="B" {{ $question->correct_option == 'B' ? 'selected' : '' }}>Option B</option>
                                <option value="C" {{ $question->correct_option == 'C' ? 'selected' : '' }}>Option C</option>
                                <option value="D" {{ $question->correct_option == 'D' ? 'selected' : '' }}>Option D</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-primary" id="add-question">Add Question</button>
            <button type="submit" class="btn btn-success">Update Quiz</button>
        </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let questionIndex = {{ $quiz->questions->count() }};

            function updateQuestionNumbers() {
                const questionGroups = document.querySelectorAll('.question-group');
                questionGroups.forEach((group, index) => {
                    group.setAttribute('data-index', index);
                    group.querySelector('.question-label').innerText = `Question ${index + 1}`;
                    group.querySelector('input[name^="questions"]').name = `questions[${index}]`;
                    group.querySelector('input[name^="marks"]').name = `marks[${index}]`;
                    const options = group.querySelectorAll('input[name^="options"]');
                    options.forEach((option, optionIndex) => {
                        option.name = `options[${index}][]`;
                    });
                    group.querySelector('select[name^="correct_options"]').name = `correct_options[${index}]`;
                });
                questionIndex = questionGroups.length;
            }

            document.getElementById('add-question').addEventListener('click', function () {
                const container = document.getElementById('questions-container');
                const questionBlock = document.createElement('div');
                questionBlock.className = 'question-group';
                questionBlock.setAttribute('data-index', questionIndex);

                questionBlock.innerHTML = `
                    <hr>
                    <div class="form-group">
                        <label class="question-label" for="questions[${questionIndex}]">Question ${questionIndex + 1}</label>
                        <input type="text" class="form-control" name="questions[${questionIndex}]" required>
                    </div>
                    <div class="form-group">
                        <label for="marks[${questionIndex}]">Marks*</label>
                        <input type="number" class="form-control" name="marks[${questionIndex}]" required>
                    </div>
                    <div class="form-group">
                        <label>Options</label>
                        <input type="text" class="form-control" name="options[${questionIndex}][]" required>
                        <input type="text" class="form-control" name="options[${questionIndex}][]" required>
                        <input type="text" class="form-control" name="options[${questionIndex}][]" required>
                        <input type="text" class="form-control" name="options[${questionIndex}][]" required>
                    </div>
                    <div class="form-group">
                        <label for="correct_options[${questionIndex}]">Correct Option*</label>
                        <select class="form-control" name="correct_options[${questionIndex}]" required>
                            <option value="A">Option A</option>
                            <option value="B">Option B</option>
                            <option value="C">Option C</option>
                            <option value="D">Option D</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                `;

                container.appendChild(questionBlock);
                updateQuestionNumbers();
            });

            document.getElementById('questions-container').addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-question')) {
                    e.target.parentElement.remove();
                    updateQuestionNumbers();
                }
            });

            updateQuestionNumbers();
        });
    </script>
</x-layout>
