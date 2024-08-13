<x-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <livewire:student.sidebar :currentPage=StudentSidebarLink::ModuleContent :currentModule=$module_id>

    <div class="viewport-container container-fluid p-0" style="overflow-x: auto;">
        @livewire('student.module-header', ['currentPage' => "Content", 'currentModuleId' => $module_id])
        <div class="p-4">
            <div class="d-flex">
                <div class="me-auto">
                    <div>
                        <h3>{{ $content->title }}</h3>
                    </div>
                    <div class="mt-3">
                        <p>{{ $content->description }}</p>
                    </div>
                </div>
                <div class="m-4 d-md-block"></div>
                <p class="text-end text-muted">Published <br> {{ $content->created_at->format('h:iA, d M Y') }}</p>
            </div>
            @if ($content->file_path)
            <div class="row justify-content-center mt-4">
                <div class="col-lg-6 col-md-8 text-md-center">
                    <h5 class="mb-3">Uploaded File</h5>
                    <livewire:content-preview :fileUrl='$content->file_path' lazy />
                </div>
            </div>
            @endif
        </div>   
    </div>
</x-layout>
