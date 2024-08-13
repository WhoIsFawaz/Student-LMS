<x-layout>
    <x-slot name="title">
        {{ __('News') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleNews :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => "News", 'currentModuleId' => $module_id])
        <div class="p-4">
        <div class="tab-content" id="newsTabsContent">
            <div class="tab-pane fade show active" id="news" role="tabpanel">
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Time Created/Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsItems as $news)
                                <tr>
                                    <td><a href="{{ route('modules.student.news.show', ['module_id' => $module->module_id, 'news' => $news->news_id]) }}">{{ $news->news_title }}</a></td>
                                    <td>{{ $news->news_description }}</td>
                                    <td>
                                        @if (!empty($news->updated_at))
                                            Updated at: {{ $news->updated_at->format('h:iA, d M') }}
                                        @else
                                            Created at: {{ $news->created_at->format('h:iA, d M') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</x-layout>
