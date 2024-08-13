<x-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleAssignment :currentModule=$module_id>

<div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => $assignment->title, 'currentModuleId' => $module_id])
        <div class="p-4">
            <h1>{{ $assignment->title }}</h1>
            <p>{{ $assignment->description }}</p>
            <p><strong>Weightage:</strong> {{ $assignment->weightage }}</p>
            <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>
            @if($assignment->file_path)
            {{$assignment->file_path}}
                <p><strong>File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">{{ $fileName }}</a></p>
            @endif
            <h2>Student Submissions</h2>
            @if($submissions->isEmpty())
                <p>No submissions found.</p>
            @else
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Description</th>
                            <th>Files</th>
                            <th>Submission Date</th>
                            <th>Grade</th>
                            <th>Feedback</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submissions as $submission)
                            <tr>
                                <td>{{ $submission->user->name }}</td>
                                <td>{{ $submission->submission_description }}</td>
                                <td>
                                    @foreach (json_decode($submission->submission_files) as $file)
                                        <a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a><br>
                                    @endforeach
                                </td>
                                <td>{{ $submission->submission_date }}</td>
                                <td>{{ $submission->grade }}</td>
                                <td>{{ $submission->feedback }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gradeModal-{{ $submission->assignment_submission_id }}">Grade</button>
    
                                    <!-- Grade Modal -->
                                    <div class="modal fade" id="gradeModal-{{ $submission->assignment_submission_id }}" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel-{{ $submission->assignment_submission_id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gradeModalLabel-{{ $submission->assignment_submission_id }}">Grade Submission</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('modules.professor.assignments.gradeSubmission', [$module_id, $assignment->assignment_id, $submission->assignment_submission_id]) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="grade">Grade</label>
                                                            <select class="form-control" id="grade" name="grade" required>
                                                                <option value="A+">A+</option>
                                                                <option value="A">A</option>
                                                                <option value="A-">A-</option>
                                                                <option value="B+">B+</option>
                                                                <option value="B">B</option>
                                                                <option value="B-">B-</option>
                                                                <option value="C+">C+</option>
                                                                <option value="C">C</option>
                                                                <option value="C-">C-</option>
                                                                <option value="D+">D+</option>
                                                                <option value="D">D</option>
                                                                <option value="D-">D-</option>
                                                                <option value="F">F</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="feedback">Feedback</label>
                                                            <textarea class="form-control" id="feedback" name="feedback" rows="3">{{ $submission->feedback }}</textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Grade Modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    
        <!-- Include Bootstrap JS for modal functionality -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </x-app-layout>
