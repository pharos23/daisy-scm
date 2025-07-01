@php
    App::setLocale(session('locale', config('app.locale')));
@endphp
<!DOCTYPE html>
{{-- Blade to register a new user --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Register') }}</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Styles --}}
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center">

<div class="w-full max-w-md p-8 shadow-lg rounded-box bg-base-100">
    <h1 class="text-2xl font-bold text-center mb-6">{{ __('Register') }}</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="label">
                <span class="label-text">{{ __('Name') }}</span>
            </label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="input input-bordered w-full @error('name') input-error @enderror"
            >
            @error('name')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

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
                autocomplete="new-password"
                class="input input-bordered w-full @error('password') input-error @enderror"
            >
            @error('password')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password-confirm" class="label">
                <span class="label-text">{{ __('Confirm Password') }}</span>
            </label>
            <input
                id="password-confirm"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="input input-bordered w-full"
            >
        </div>

        {{-- Submit --}}
        <div class="form-control mt-4">
            <button type="submit" class="btn btn-primary w-full">
                {{ __('Register') }}
            </button>
        </div>

        {{-- Already registered? --}}
        <div class="text-center mt-2">
            <p class="text-sm">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="link link-hover">
                    {{ __('Login') }}
                </a>
            </p>
        </div>
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
