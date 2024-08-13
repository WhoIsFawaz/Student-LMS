<x-layout>
    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleMeetings :currentModule=$module_id>
    
    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Edit Meeting", 'currentModuleId' => $module_id])
        <div class="p-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form
                            action="{{ route('modules.professor.meetings.update', [$module->module_id, $meeting->meeting_id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="meeting_date">Meeting Date</label>
                                <input type="date" name="meeting_date" id="meeting_date" class="form-control"
                                    value="{{ $meeting->meeting_date }}" required>
                            </div>

                            <div class="form-group">
                                <label for="timeslot">Timeslot</label>
                                <select name="timeslot" id="timeslot" class="form-control" required>
                                    @foreach($times as $time)
                                        <option value="{{ $time }}" {{ $meeting->timeslot == $time ? 'selected' : '' }}>
                                            {{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Meeting</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>