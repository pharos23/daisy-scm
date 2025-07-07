<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <title>{{ __('Change Password') }}</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Styles --}}
    @vite(['resources/css/app.css', 'resources/js/pages/login.js'])
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center relative">

{{-- Theme Switcher --}}
<div class="flex justify-center absolute top-0 left-0 m-5">
    <label class="toggle text-base-content">
        <input type="checkbox" value="synthwave" id="theme-switcher" class="theme-controller" />
        <svg aria-label="sun" xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                <circle cx="12" cy="12" r="4"></circle>
                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
            </g>
        </svg>
        <svg aria-label="moon" xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor">
                <path d="M12 3a6 6 0 009 9 9 9 0 11-9-9Z"/>
            </g>
        </svg>
    </label>
</div>

{{-- Change Password Card --}}
<div class="w-full max-w-md p-8 shadow-lg rounded-box bg-base-100">
    <h1 class="text-2xl font-bold text-center mb-6">{{ __('Change Password') }}</h1>

    <form method="POST" action="{{ route('forcepassword.change') }}" class="space-y-4">
        @csrf

        {{-- show the logged in username --}}
        <div class="text-center mb-4">
            <p class="text-base-content">{{ __('Logged in as') }} <span class="font-semibold">{{ Auth::user()->username }}</span></p>
        </div>

        {{-- New Password --}}
        <div>
            <label for="password" class="label">
                <span class="label-text">{{ __('New Password') }}</span>
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="input input-bordered w-full @error('password') input-error @enderror"
                placeholder="********"
            >
            @error('password')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="label">
                <span class="label-text">{{ __('Confirm New Password') }}</span>
            </label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="input input-bordered w-full"
                placeholder="********"
            >
        </div>

        {{-- Submit --}}
        <div class="form-control mt-4">
            <button type="submit" class="btn btn-primary w-full">
                {{ __('Update Password') }}
            </button>
        </div>
    </form>
</div>
</body>
</html>
