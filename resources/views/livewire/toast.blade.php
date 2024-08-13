<div aria-live="polite" aria-atomic="true" class="position-relative">
    <!-- Position it -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <!-- Toasts -->
        @foreach ($toasts as $index => $toast)
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" wire:key="toast-{{ $index }}">
                <div class="toast-header @if($toast['type'] === 'success') bg-success text-white @elseif($toast['type'] === 'error') bg-danger text-white @endif">
                    <strong class="me-auto">{{ ucfirst($toast['type']) }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" wire:click="removeToast({{ $index }})"></button>
                </div>
                <div class="toast-body">
                    {{ $toast['message'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>

@script
<script>
    $wire.on('toast-auto-hide', (event) => {
        setTimeout(() => {
            $wire.dispatch('removeToast', { index: event.index });
        }, 3000);
    });
</script>
@endscript