<x-layout>
    <x-hero-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div>
            <a href="/">
                <div class="center-logo mb-3">
                    <img id="logo-light" src="/images/logo-transparent-white.png" alt="Logo" width="350">
                    <img id="logo-dark" src="/images/logo-transparent-dark.png" alt="Logo"
                        width="350">
                </div>
            </a>
        </div>

        <div>
            <div class="container">
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="">
                        <p class="text-lg font-semibold mb-4">
                            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password">
                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-secondary me-2" href="/">Back</a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-hero-card>
</x-layout>


<script>
    let logoLight = document.querySelectorAll('.logo-light');
    let logoDark = document.querySelectorAll('.logo-dark');

    updateTheme = function() {
        const theme = getTheme();

        logoDark.forEach((e) => e.style.display = (theme === 'dark') ? 'block' : 'none'); // elements
        logoLight.forEach((e) => e.style.display = (theme === 'light') ? 'block' : 'none'); 
    }
</script>