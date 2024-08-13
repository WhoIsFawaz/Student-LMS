<x-layout>
    <x-slot name="title">
        {{ __('Create News') }}
    </x-slot>

    <livewire:professor.sidebar :currentPage=ProfessorSidebarLink::ModuleNews :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Create News Item", 'currentModuleId' => $module_id])
        <div class="p-4">
            <form action="{{ route('modules.professor.news.store', ['module_id' => $module->module_id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="news_title">News Title</label>
                    <input type="text" class="form-control" id="news_title" name="news_title" required>
                </div>
                <div class="form-group">
                    <label for="news_description">News Description</label>
                    <textarea class="form-control" id="news_description" name="news_description" required></textarea>
                </div>
                <input type="hidden" name="module_id" value="{{ $module->module_id }}">
                <button type="submit" class="btn btn-success">Upload News</button>
            </form>
        </div>
    </div>
</x-layout>
