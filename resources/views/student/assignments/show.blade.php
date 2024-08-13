<x-app-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleAssignment :currentModule=$module_id>
        <div class="viewport-container container-fluid p-0">
            @livewire('student.module-header', ['currentPage' => $assignment->title, 'currentModuleId' => $module_id])
            <div class="p-4">
                <div class="mb-5">
                    <p>{{ $assignment->description }}</p>
                    @php($due_date = \Carbon\Carbon::parse($assignment->due_date))
                    <p>Due on <strong>{{ $assignment->due_date }}</strong>.</p>
                    <p>Weightage: <strong>{{ $assignment->weightage }}</strong></p>
                    @if (is_string($assignment->file_path))
                        <div class="row justify-content-left mt-4">
                            <div class="col-lg-6 col-md-8">
                                <h5 class="mb-3">Uploaded File</h5>
                                <livewire:content-preview :file-url="$assignment->file_path" lazy />
                            </div>
                        </div>
                    @endif

                </div>

                <div>
                    <ul class="nav nav-pills flex-scroll-x gap-2 p-1 small bg-body-secondary rounded-5 mb-3 me-3"
                        style="width: fit-content;" id="content-tab" role="tablist">
                        <li class="nav-item d-inline-block" role="presentation">
                            <a id="tab-submission" class="nav-link rounded-5 active" data-bs-toggle="tab"
                                href="#folder-submission" role="tab" aria-controls="folder-submission"
                                aria-selected="true">New Submission</a>
                        </li>
                        @foreach ($assignment->submissions as $submission)
                            <li class="nav-item d-inline-block" role="presentation">
                                <a class="nav-link rounded-5 }}" id="tab-{{ $submission->assignment_submission_id }}"
                                    data-bs-toggle="tab" href="#folder-{{ $submission->assignment_submission_id }}"
                                    role="tab" aria-controls="folder-{{ $submission->assignment_submission_id }}"
                                    aria-selected="true">Submission {{ $loop->index + 1 }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="folderTab">
                        <div class="tab-pane fade show active" id="folder-submission" role="tabpanel"
                            aria-labelledby="tab-submission">
                            <form
                                action="{{ route('modules.student.assignments.submit', [$module_id, $assignment->assignment_id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="files">Upload Files</label>
                                    <input type="file" name="files[]" id="files" class="form-control" multiple
                                        required>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            </form>
                        </div>
                        @foreach ($assignment->submissions as $submission)
                            <div class="tab-pane fade" id="folder-{{ $submission->assignment_submission_id }}"
                                role="tabpanel" aria-labelledby="tab-{{ $submission->assignment_submission_id }}">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        <div class="mb-3">
                                            @if ($submission->grade)
                                                <h5 class="mb-1 fw-normal">Grade: <span
                                                        class="fw-bolder">{{ $submission->grade }}</span></h5>
                                            @else
                                                <h5 class="mb-1">Not graded</h5>
                                            @endif
                                            @if ($submission->feedback)
                                                <h5 class="mb-1 fw-normal">Feedback: <span
                                                        class="fw-bolder">{{ $submission->feedback }}</span></h5>
                                            @else
                                                <h5 class="mb-1">No feedback provided</h5>
                                            @endif
                                        </div>
                                        <h6 class="mb-1">Submitted Description</h6>
                                        <p>{{ $submission->submission_description }}</p>
                                    </div>
                                    <div class="m-4 d-md-block"></div>
                                    <div class="text-end">
                                        <p>Submitted on <strong>{{ $submission->submission_date }}</strong>.</p>
                                    </div>
                                </div>
                                @if (is_string($submission->submission_files))
                                    @foreach (json_decode($submission->submission_files) as $file)
                                        <div class="row justify-content-center mt-4">
                                            <div class="col-lg-6 col-md-8 text-md-center">
                                                <h5 class="mb-3">Uploaded File</h5>
                                                <livewire:content-preview :fileUrl=$file lazy />
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
