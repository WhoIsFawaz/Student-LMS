<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleQuiz :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => 'Quizzes', 'currentModuleId' => $module_id])
        <div class="p-4">
            <ul class="nav nav-pills flex-scroll-x gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;"
                id="quizzes-tab" role="tablist">
                <li class="nav-item d-inline-block" role="presentation">
                    <button class="nav-link active rounded-5" id="pills-pending-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-pending" type="button" role="tab" aria-controls="pills-pending"
                        aria-selected="false">Pending</button>
                </li>
                <li class="nav-item d-inline-block" role="presentation">
                    <button class="nav-link rounded-5" id="pills-completed-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-completed" type="button" role="tab" aria-controls="pills-completed"
                        aria-selected="true">Completed</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-pending" role="tabpanel"
                    aria-labelledby="pills-pending-tab" tabindex="0">
                    @if ($quizzes->isEmpty())
                        <p>No active quizzes found for this module.</p>
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
                                @foreach ($quizzes as $quiz)
                                    <tr>
                                        <td>{{ $quiz->quiz_title }}</td>
                                        <td>{{ $quiz->quiz_description }}</td>
                                        <td>{{ $quiz->quiz_date }}</td>
                                        <td>
                                            <a href="{{ route('modules.student.quizzes.show', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}"
                                                class="btn btn-info btn-sm start-button"
                                                data-quiz-date="{{ $quiz->quiz_date }}">Start</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-completed" role="tabpanel"
                    aria-labelledby="pills-completed-tab" tabindex="0">
                    @if ($completedQuizzes->isEmpty())
                        <p>No completed quizzes found for this module.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Attempt Date</th>
                                    <th>Score</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completedQuizzes as $attempt)
                                    <tr>
                                        <td>{{ $attempt->quiz->quiz_title }}</td>
                                        <td>{{ $attempt->created_at }}</td>
                                        <td>{{ $attempt->score }}</td>
                                        <td>{{ $attempt->grade }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const startButtons = document.querySelectorAll('.start-button');
                startButtons.forEach(button => {
                    const quizDate = new Date(button.getAttribute('data-quiz-date'));
                    const now = new Date();

                    if (now < quizDate) {
                        button.classList.add('disabled');
                        button.setAttribute('disabled', 'true');
                        button.textContent = 'Starts at ' + quizDate.toLocaleString();
                    } else {
                        button.classList.remove('disabled');
                        button.removeAttribute('disabled');
                    }
                });

                setInterval(() => {
                    startButtons.forEach(button => {
                        const quizDate = new Date(button.getAttribute('data-quiz-date'));
                        const now = new Date();

                        if (now >= quizDate && button.hasAttribute('disabled')) {
                            button.classList.remove('disabled');
                            button.removeAttribute('disabled');
                            button.textContent = 'Start';
                        }
                    });
                }, 1000); // Check every second to update the buttons
            });
        </script>
</x-layout>
