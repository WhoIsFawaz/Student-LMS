<x-layout>
    <x-slot name="title">
        {{ __('Edit News') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleNews :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Edit News", 'currentModuleId' => $module_id])
        <div class="p-4">
        <form action="{{ route('modules.professor.news.update', ['module_id' => $module->module_id, 'news' => $newsItem->news_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="news_title">News Title</label>
                <input type="text" class="form-control" id="news_title" name="news_title" value="{{ $newsItem->news_title }}" required>
            </div>
            <div class="form-group">
                <label for="news_description">News Description</label>
                <textarea class="form-control" id="news_description" name="news_description" required>{{ $newsItem->news_description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update News</button>
        </form>
        </div>
    </div>
</x-layout>
