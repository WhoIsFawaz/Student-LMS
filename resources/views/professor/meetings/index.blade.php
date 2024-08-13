<x-layout>
    <x-slot name="title">
        {{ __('Meetings') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleMeetings :currentModule=$module_id>

        <div class="viewport-container container-fluid p-0">
            @livewire('professor.module-header', ['currentPage' => 'Meetings', 'currentModuleId' => $module_id])
            <div class="p-4">
                <a href="{{ route('modules.professor.meetings.create', ['module_id' => $module->module_id]) }}"
                    class="btn btn-primary mb-3">Create Meeting Slot</a>
                <div class="row">
                    @forelse ($meetings as $meeting)
                        <div class="col-md-4 mb-4">
                            <div
                                class="card border shadow">
                                <div class="card-header">
                                    Prof {{ $meeting->professor_first_name }} {{ $meeting->professor_last_name }}<br>
                                    <span class="h6">Conducted at <strong>{{ $meeting->timeslot }}</strong></span>

                                </div>
                                <div class="card-body">
                                    <p class="card-text">Status: <strong>{{ $meeting->status }}</strong></p>
                                    @if ($meeting->status == 'pending')
                                        <form
                                            action="{{ route('modules.professor.meetings.update', [$module->module_id, $meeting->meeting_id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-success">Accept</button>
                                        </form>
                                        <form
                                            action="{{ route('modules.professor.meetings.update', [$module->module_id, $meeting->meeting_id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>
                                    @elseif ($meeting->status == 'vacant')
                                        <p class="card-text">Nobody has applied yet</p>
                                    @endif
                                    @if (is_string($meeting->student_first_name))
                                        <p class="card-text">Student: <strong>{{ $meeting->student_first_name }}
                                                {{ $meeting->student_last_name }}</strong></p>
                                    @endif

                                    <a href="{{ route('modules.professor.meetings.edit', [$module->module_id, $meeting->meeting_id]) }}"
                                        class="btn btn-warning">Edit</a>
                                    <form
                                        action="{{ route('modules.professor.meetings.destroy', [$module->module_id, $meeting->meeting_id]) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this meeting?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="p-3">No meetings available.</p>
                    @endforelse
                </div>
            </div>
        </div>
</x-layout>
