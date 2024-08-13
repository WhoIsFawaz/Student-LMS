<div class="w-100 d-flex justify-content-center">
    <div class="toast-container position-absolute p-4">
        @isset($errors)
            @foreach ($errors->all() as $message)
                <div class="toast bg-danger w-100" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                        <div class="d-flex text-white">
                            <div class="me-auto text-white">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                {{ $message }}
                            </div>
                            <div class="ps-4">
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset

        @if (session('error'))
            <div class="toast bg-danger w-100" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex text-white">
                        <div class="me-auto text-white">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            {{ session('error') }}
                        </div>
                        <div class="ps-4">
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="toast bg-success w-100" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex text-white">
                        <div class="me-auto text-white">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            {{ session('success') }}
                        </div>
                        <div class="ps-4">
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('status'))
        <div class="toast border border-primary w-100" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <div class="d-flex">
                    <div class="me-auto">
                        <i class="bi bi-exclamation-circle-fill text-primary me-3"></i>
                        {{ session('status') }}
                    </div>
                    <div class="ps-4">
                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>
