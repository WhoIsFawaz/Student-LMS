<div id="assignment-table">
    <div class="d-flex">
        <div class="me-auto">
            <ul class="nav nav-pills flex-scroll-x gap-2 p-1 small bg-body-secondary rounded-5 mb-3 me-3" id="content-tab"
                role="tablist">
                <li class="nav-item d-inline-block" role="presentation">
                    <a id="tab-pending" class="nav-link rounded-5 {{ $currentFolder == 0 ? 'active' : '' }}"
                        data-bs-toggle="tab" href="#folder-pending" role="tab" aria-controls="folder-pending"
                        aria-selected="{{ $currentFolder == 0 ? 'true' : 'false' }}"
                        wire:click="updateCurrentFolder(0)">Pending</a>
                </li>
                <li class="nav-item d-inline-block" role="presentation">
                    <a id="tab-submitted" class="nav-link rounded-5 {{ $currentFolder == 1 ? 'active' : '' }}"
                        data-bs-toggle="tab" href="#folder-submitted" role="tab" aria-controls="folder-submitted"
                        aria-selected="{{ $currentFolder == 1 ? 'true' : 'false' }}"
                        wire:click="updateCurrentFolder(1)">Submitted</a>
                </li>
            </ul>
        </div>
        <div class="me-3" wire:loading>
            <x-spinner />
        </div>
        <div class="row g-3">
            <div class="col-auto ">
                <input type="text" id="search-input" class="form-control" aria-describedby="search-input"
                    placeholder="Search..." wire:model.live="search">
            </div>
        </div>
    </div>
    <div class="tab-content" id="folderTab">
        <div class="tab-pane fade {{ $currentFolder == 0 ? 'show active' : '' }}" id="folder-pending" role="tabpanel"
            aria-labelledby="tab-pending">
            @if ($pending->isEmpty())
                <p class="p-3">No pending assignments found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"
                                wire:click="updateSort('{{ $sortColumn != 'title' ? 'title_desc' : $sort }}')"
                                role="button">
                                Title
                                @if ($sort == 'title_asc')
                                    <i class="bi bi-arrow-down"></i>
                                @elseif ($sort == 'title_desc')
                                    <i class="bi bi-arrow-up"></i>
                                @endif
                            </th>
                            <th scope="col"
                                wire:click="updateSort('{{ $sortColumn != 'upload_date' ? 'latest' : $sort }}')"
                                role="button">
                                Due Date
                                @if ($sort == 'earliest')
                                    <i class="bi bi-arrow-down"></i>
                                @elseif ($sort == 'latest')
                                    <i class="bi bi-arrow-up"></i>
                                @endif
                            </th>
                            <th scope="col" role="button">
                                Weightage
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pending as $assignment)
                            <tr class="">
                                <th scope="row">
                                    <a href="{{ route('modules.student.assignments.show', [$module_id, $assignment->assignment_id]) }}"
                                        class="no-text-decoration">
                                        {{ $assignment->title }}
                                    </a>
                                </th>
                                <td>
                                    {{ $assignment->due_date }}
                                </td>
                                <td>
                                    {{ $assignment->weightage }} %
                                </td>
                            </tr>
                        @empty
                            <p class="p-3">No content found.</p>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        <div class="tab-pane fade {{ $currentFolder == 1 ? 'show active' : '' }}" id="folder-submitted" role="tabpanel"
            aria-labelledby="tab-submitted">
            @if ($submitted->isEmpty())
                <p class="p-3">No submitted assignments found.</p>
            @else
            
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"
                                wire:click="updateSort('{{ $sortColumn != 'title' ? 'title_desc' : $sort }}')"
                                role="button">
                                Title
                                @if ($sort == 'title_asc')
                                    <i class="bi bi-arrow-down"></i>
                                @elseif ($sort == 'title_desc')
                                    <i class="bi bi-arrow-up"></i>
                                @endif
                            </th>
                            <th scope="col" role="button">
                                Submission Date
                            </th>
                            <th scope="col">
                                Weightage
                            </th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($submitted as $assignment)
                    
                            @foreach ($assignment->submissions as $submission)
                                <tr class="">
                                    <th scope="row">
                                        <a href="{{ route('modules.student.assignments.show', [$module_id, $assignment->assignment_id]) }}"
                                            class="no-text-decoration">
                                            {{ $assignment->title }}
                                        </a>
                                    </th>
                                    <td>
                                        {{ $submission->submission_date }}
                                    </td>
                                    <td>
                                        {{ $assignment->weightage }} %
                                    </td>
                                    <td>
                                        @if ($submission->grade)
                                            {{ $submission->grade }}
                                        @else
                                            <span class="text-muted"></span>Not graded</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
