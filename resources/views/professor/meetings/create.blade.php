<x-layout>
    <x-slot name="title">
        {{ __('Create Meeting Slot') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleMeetings :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Create Meeting", 'currentModuleId' => $module_id])
        <div class="p-4">
            <form action="{{ route('modules.professor.meetings.store', ['module_id' => $module->module_id]) }}" method="POST">
                @csrf
                @method('post')
                <div class="form-group">
                    <label for="meeting_date">Meeting Date:</label>
                    <input type="date" name="meeting_date" id="meeting_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="times">Time:</label>
                    <select name="time" id="times" class="form-control" required>
                        @foreach ($times as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Create Timeslot</button>
                <br> 
                <a href="{{ route('modules.professor.meetings.index', ['module_id' => $module->module_id]) }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
</x-layout>
