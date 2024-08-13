<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleQuiz :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Quizzes", 'currentModuleId' => $module_id])
        <div class="p-4">
        <div class="alert alert-info" role="alert">
            <strong>Time Remaining: <span id="timer"></span></strong>
        </div>
        <form id="quiz-form" action="{{ route('modules.student.quizzes.attempt', ['module_id' => $module->module_id, 'id' => $quiz->quiz_id]) }}" method="POST">
            @csrf
            @foreach ($quiz->questions as $index => $question)
            <div class="form-group">
                <label for="question">{{ $index + 1 }}. {{ $question->question }}</label>
                <input type="hidden" name="questions[]" value="{{ $question->quiz_questions_id }}">
                <div>
                    <input type="radio" name="answers[{{ $index }}]" value="A"> {{ $question->option_a }}
                </div>
                <div>
                    <input type="radio" name="answers[{{ $index }}]}" value="B"> {{ $question->option_b }}
                </div>
                <div>
                    <input type="radio" name="answers[{{ $index }}]}" value="C"> {{ $question->option_c }}
                </div>
                <div>
                    <input type="radio" name="answers[{{ $index }}]}" value="D"> {{ $question->option_d }}
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-success">Submit Quiz</button>
        </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear local storage on page load to reset the quiz
            localStorage.removeItem('quizDuration');
            localStorage.removeItem('quizAnswers');
            localStorage.removeItem('navigationFlag');

            var duration = {{ $quiz->duration }} * 60; // Duration in seconds
            var timer = document.getElementById('timer');

            var interval = setInterval(function() {
                var minutes = Math.floor(duration / 60);
                var seconds = duration % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                timer.textContent = minutes + ':' + seconds;
                localStorage.setItem('quizDuration', duration); // Save remaining duration to localStorage

                if (--duration < 0) {
                    clearInterval(interval);
                    alert('Time is up!');
                    document.getElementById('quiz-form').submit();
                }
            }, 1000);

            // Save answers to localStorage on change
            document.querySelectorAll('input[name^="answers"]').forEach(function(input) {
                input.addEventListener('change', function() {
                    var answers = JSON.parse(localStorage.getItem('quizAnswers') || '{}');
                    answers[input.name.match(/\d+/)[0]] = input.value;
                    localStorage.setItem('quizAnswers', JSON.stringify(answers));
                });
            });

            function submitQuiz() {
                // Clear localStorage when submitting quiz
                localStorage.removeItem('quizDuration');
                localStorage.removeItem('quizAnswers');
                localStorage.removeItem('navigationFlag');
                document.getElementById('quiz-form').submit();
            }

            // Update the event listener to properly handle the navigationFlag
            window.addEventListener('beforeunload', function(e) {
                if (!localStorage.getItem('navigationFlag')) {
                    e.preventDefault();
                    e.returnValue = '';
                    alert('You will score 0 if you leave the quiz!');
                }
            });

            // Update form submission event
            document.getElementById('quiz-form').addEventListener('submit', function(e) {
                window.removeEventListener('beforeunload', submitQuiz);
                localStorage.setItem('navigationFlag', 'true');
            });

            // Set navigation flag on page load
            localStorage.setItem('navigationFlag', 'false');
        });
    </script>
</x-layout>
