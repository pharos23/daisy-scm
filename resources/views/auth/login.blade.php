@php
    App::setLocale(session('locale', config('app.locale')));
@endphp
<!DOCTYPE html>
{{-- Blade to login with a user username and password --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Styles --}}
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center">

<div class="w-full max-w-md p-8 shadow-lg rounded-box bg-base-100">
    <h1 class="text-2xl font-bold text-center mb-6">{{ __('Login') }}</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Username --}}
        <div>
            <label for="username" class="label">
                <span class="label-text">{{ __('Username') }}</span>
            </label>
            <input
                id="username"
                name="username"
                value="{{ old('username') }}"
                required
                autofocus
                class="input input-bordered w-full @error('username') input-error @enderror"
            >
            @error('username')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="label">
                <span class="label-text">{{ __('Password') }}</span>
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="input input-bordered w-full @error('password') input-error @enderror"
            >
            @error('password')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="form-control">
            <label class="label cursor-pointer justify-start gap-2">
                <input
                    class="checkbox"
                    type="checkbox"
                    name="remember"
                    id="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <span class="label-text">{{ __('Remember Me') }}</span>
            </label>
        </div>

        {{-- Submit --}}
        <div class="form-control mt-4">
            <button type="submit" class="btn btn-primary w-full">
                {{ __('Login') }}
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center mt-3">
                <a class="btn btn-outline btn-sm mt-2" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
        @endif
    </form>
</div>

{{-- Theme Toggle Script --}}
<script>
    const themeSwitcher = document.getElementById('theme-switcher');

    function toggleTheme() {
        const theme = themeSwitcher.checked ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    }

    window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
            themeSwitcher.checked = (savedTheme === 'dark');
        }
    });

    themeSwitcher.addEventListener('change', toggleTheme);
</script>

</body>
</html>
