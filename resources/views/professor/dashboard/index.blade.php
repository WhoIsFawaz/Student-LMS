<x-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::Dashboard />

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => 'Dashboard'])
        <div class="p-4">
            <ul class="nav nav-pills flex-scroll-x gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;" id="dashboard-tab" role="tablist">
                <li class="nav-item d-inline-block" role="presentation">
                    <button class="nav-link active rounded-5" id="pills-calendar-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-calendar" type="button" role="tab" aria-controls="pills-calendar"
                        aria-selected="false">Calendar</button>
                </li>
                <li class="nav-item d-inline-block" role="presentation">
                    <button class="nav-link rounded-5" id="pills-announcements-tab" data-bs-toggle="pill" data-bs-target="#pills-announcements"
                        type="button" role="tab" aria-controls="pills-announcements" aria-selected="true">Announcements</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-calendar" role="tabpanel" aria-labelledby="pills-calendar-tab"
                    tabindex="0">
                    <div id="calendar" class="mb-4"></div>
                </div>
                <div class="tab-pane fade" id="pills-announcements" role="tabpanel" aria-labelledby="pills-announcements-tab"
                    tabindex="0">
                    <div class="row g-4">
                        @php
                            $sortedEvents = $events->sortBy(function ($event) {
                                $eventStartDate = \Carbon\Carbon::parse($event->start);
                                $today = \Carbon\Carbon::today();
                                return $today->diffInDays($eventStartDate);
                            });
                        @endphp

                        @foreach ($sortedEvents as $event)
                            @php
                                $eventStartDate = \Carbon\Carbon::parse($event->start);
                                $today = \Carbon\Carbon::today();
                                $daysUntilEvent = $today->diffInDays($eventStartDate);
                                $eventIsToday = $eventStartDate->isSameDay($today);
                            @endphp
                            @if ($eventStartDate->isToday() || ($eventStartDate->isFuture() && $daysUntilEvent <= 7))
                                <div class="col-lg-4 col-md-6 mb-4">
                                    @if ($event->type === 'assignment')
                                        <a href="{{ route('modules.professor.assignments.show', [$event->module_id, $event->id]) }}" class="text-decoration-none">
                                    @elseif ($event->type === 'quiz')
                                        <a href="{{ route('modules.professor.quizzes.index', [$event->module_id]) }}" class="text-decoration-none">
                                    @elseif ($event->type === 'meeting')
                                        <a href="{{ route('modules.professor.meetings.index', [$event->module_id]) }}" class="text-decoration-none">
                                    @endif
                                    <div class="card rounded shadow border h-100">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">
                                                @if ($event->type === 'meeting')
                                                    Meeting
                                                @else
                                                    {{ $event->title }}
                                                @endif
                                            </h5>
                                            <p class="card-text">{{ $event->module_name }}</p>
                                            <p class="card-text">{{ $event->start }}</p>
                                            @if ($event->type === 'assignment')
                                                <span class="badge bg-warning text-dark mt-auto">Assignment</span>
                                            @elseif($event->type === 'quiz')
                                                <span class="badge bg-info text-dark mt-auto">Quiz</span>
                                            @elseif($event->type === 'meeting')
                                                <p class="card-text">Student: {{ $event->student_name }}</p>
                                                <p class="card-text">Timeslot: {{ $event->timeslot }}</p>
                                                <span class="badge bg-success text-dark mt-auto">Meeting</span>
                                            @endif
    
                                            @if ($eventIsToday)
                                                <p class="card-text mt-2"><strong>TODAY</strong></p>
                                            @else
                                                <p class="card-text mt-2">{{ $daysUntilEvent }}
                                                    day{{ $daysUntilEvent != 1 ? 's' : '' }} until event</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($event->type === 'assignment' || $event->type === 'quiz' || $event->type === 'meeting')
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>
    <script>
        const headerDescription = document.getElementById('header-description');

        document.addEventListener('DOMContentLoaded', function() {
            if (headerDescription) {
                updateHeaderDescription("Calendar");
            }
            var calendarEl = document.getElementById('calendar');
            var events = @json($events);

            var calendarEvents = events.map(function(event) {
                var eventData = {
                    title: event.type === 'meeting' ? 'Meeting' : event.title,
                    start: event.start,
                    end: event.end || event.start,
                    extendedProps: {
                        module_name: event.module_name
                    }
                };

                if (event.type === 'assignment') {
                    eventData.color = '#f0ad4e';
                    eventData.classNames = 'assignment-event';
                } else if (event.type === 'quiz') {
                    eventData.color = '#5bc0de';
                    eventData.classNames = 'quiz-event';
                } else if (event.type === 'meeting') {
                    eventData.color = '#5cb85c';
                    eventData.classNames = 'meeting-event';
                    eventData.extendedProps.studentName = event.student_name;
                    eventData.extendedProps.timeslot = event.timeslot;
                }

                return eventData;
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                navLinks: true,
                selectMirror: true,
                editable: false,
                dayMaxEvents: true,
                events: calendarEvents,
                eventDisplay: 'block',
                eventTextColor: 'black',
                eventContent: function(arg) {
                    var title = arg.event.title;
                    var module_name = arg.event.extendedProps.module_name;
                    var content = `<div>${title}</div><div style="font-size: 1em; color: #555;">${module_name}</div>`;

                    if (arg.event.extendedProps.studentName) {
                        content += `<div style="font-size: 1em; color: #555;">${arg.event.extendedProps.studentName}</div>`;
                    }
                    if (arg.event.extendedProps.timeslot) {
                        content += `<div style="font-size: 1em; color: #555;">${arg.event.extendedProps.timeslot}</div>`;
                    }

                    var eventContent = document.createElement('div');
                    eventContent.innerHTML = content;
                    return { domNodes: [eventContent] };
                }
            });

            calendar.render();
        });

        document.getElementById('pills-calendar-tab').addEventListener('click', function() {
            if (headerDescription) {
                updateHeaderDescription('Calendar');
            }
        });

        document.getElementById('pills-announcements-tab').addEventListener('click', function() {
            if (headerDescription) {
                updateHeaderDescription('Announcements');
            }
        });

        function updateHeaderDescription(description) {
            headerDescription.innerText = description;
        }
    </script>
    <style>
        .fc-event-main-frame .fc-event-time {
            display: none !important;
        }

        .fc-event-title.assignment-event {
            background-color: #f0ad4e !important;
            border-color: #f0ad4e !important;
            color: black !important;
        }

        .fc-event-title.quiz-event {
            background-color: #5bc0de !important;
            border-color: #5bc0de !important;
            color: black !important;
        }

        .fc-event-main {
            white-space: pre-line;
            /* Ensures line breaks are rendered */
        }

        .card {
            display: flex;
            flex-direction: column;
        }
    </style>
</x-layout>
