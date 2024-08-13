<x-layout>
    <x-hero-card>
        <div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-4">
                <a href="/">
                    <div class="center-logo mb-3">
                        <img class="logo-light" src="/images/logo-transparent-white.png" alt="Logo" width="350">
                        <img class="logo-dark" src="/images/logo-transparent-dark.png" alt="Logo" width="350">
                    </div>
                </a>
            </div>

            <div>
                <div class="container">
                    <form method="POST" action="{{ route('login') }}" style="min-width: 400px;">
                        @csrf
        
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                                required autofocus autocomplete="username">
                            @if ($errors->has('email'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
        
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" class="form-control" type="password" name="password" required
                                autocomplete="current-password">
                            @if ($errors->has('password'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
        
                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                    </div>
        
                        <div class="d-flex justify-content-end">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-decoration-none me-3" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
        
                            <button type="submit" class="btn btn-primary">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </form>
                </div>
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