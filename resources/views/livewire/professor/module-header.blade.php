<div class="p-4 border-bottom d-flex">
    <div class="me-auto d-flex">
        <div>
            <button class="btn btn-lg btn-outline-secondary d-lg-none me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                <i class="bi bi-justify"></i>
            </button>
        </div>
        <div>
            <h2>{{ $currentPage }}</h2>
            <h6>{{ $moduleName }} - {{ $moduleCode }}</h6>    
        </div>
    </div>
    <div class="">
        <x-display-mode-toggler></x-display-mode-toggler>
    </div>
</div>
