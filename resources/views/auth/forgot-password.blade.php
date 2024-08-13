<x-layout>
    <x-hero-card>
        <!-- Session Status -->

        <div class="mb-4">
            <a href="/">
                <div class="center-logo mb-3">
                    <img class="logo-light" src="/images/logo-transparent-white.png" alt="Logo" width="350">
                    <img class="logo-dark" src="/images/logo-transparent-dark.png" alt="Logo" width="350">
                </div>
            </a>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="">
                <h5 class="mb-1">
                    {{ __('Forgot your password?') }}
                </h5>
                <p>
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username">
            </div>

            <div class="d-flex justify-content-end">
                <a class="btn btn-outline-secondary me-2" href="/">Back</a>
                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
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
