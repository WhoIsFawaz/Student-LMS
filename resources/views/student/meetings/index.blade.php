<x-layout>
    <x-slot name="title">
        {{ __('Meetings') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleMeetings :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "Meetings", 'currentModuleId' => $module_id])
        <div class="p-4">
        <div class="row">
            @forelse ($meetings as $meeting)
                <div class="col-md-4 mb-4">
                    <div class="card border shadow {{ $meeting->status == 'booked' && $meeting->booked_by_user_id != auth()->id() ? 'opacity-25' : '' }}">
                        <div class="card-header">
                            Prof {{ $meeting->first_name }} {{ $meeting->last_name }}<br>
                            <span class="h6">Conducted at <strong>{{ $meeting->timeslot }}</strong></span>
                            
                        </div>
                        <div class="card-body">
                            <p class="card-text">Status: <strong>{{ $meeting->status }}</strong></p>

                            @if($meeting->status == 'vacant')
                                <form
                                    action="{{ route('modules.student.meetings.update', ['module_id' => $module->module_id, 'meeting' => $meeting->meeting_id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="booked">
                                    <input type="hidden" name="is_booked" value="true">
                                    <button type="submit" class="btn btn-success">Book this slot</button>
                                </form>
                            @elseif($meeting->status == 'booked' && $meeting->booked_by_user_id == auth()->id())
                                <form
                                    action="{{ route('modules.student.meetings.updateBooking', ['module_id' => $module->module_id, 'meeting' => $meeting->meeting_id]) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="vacant">
                                    <button type="submit" class="btn btn-danger">Cancel Booking</button>
                                </form>
                            @endif
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