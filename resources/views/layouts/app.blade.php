<!doctype html>
<html data-theme="" lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'DaisyUI - SCM', config('app.name') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-base-100 relative">

    {{-- Hover zone (small screens only) --}}
    <div id="hover-zone" class="fixed top-0 left-0 h-full w-2 z-40 block lg:hidden"></div>

    {{-- Sidebar --}}
    <aside
        id="sidebar"
        class="fixed top-0 left-0 z-50 w-50 transition-transform duration-300 transform -translate-x-full
               lg:translate-x-0 lg:relative lg:z-auto lg:transform-none
               bg-base-200 border-r border-base-content/10 shadow-md
               h-full lg:h-screen overflow-y-auto flex flex-col justify-between"
        onmouseenter="showSidebar()"
        onmouseleave="hideSidebar()"
    >
        <div class="h-full flex flex-col justify-between">
            {{-- Navigation --}}
            <ul class="menu p-4 pt-10 text-base-content space-y-1">
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                @can('view-contact')
                    <li><a href="{{ route('contacts') }}">Contacts</a></li>
                @endcan

                @hasanyrole(['Admin', 'Super Admin'])
                <div class="divider">Admin</div>
                <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                <li><a href="{{ route('roles.index') }}">Manage Roles</a></li>
                <li><a href="{{ route('permissions.index') }}">Manage Permissions</a></li>
                @endhasanyrole
            </ul>

            {{-- Footer area: User info and theme toggle --}}
            @auth
                <div class="p-4 border-t border-base-content/10 space-y-2">
                    <div class="font-bold break-words truncate">
                        {{ Auth::user()->name }}
                        <div class="text-sm font-normal text-gray-500">
                            ({{ implode(', ', Auth::user()->getRoleNames()->toArray()) }})
                        </div>
                    </div>

                    <a href="{{ route('userSettings.edit') }}" class="btn btn-ghost btn-sm w-full text-left">Settings</a>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); if (confirm('Are you sure you want to logout?')) document.getElementById('logout-form').submit();"
                       class="btn btn-ghost btn-sm w-full text-left">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>

                    <div class="flex justify-center mt-2">
                        <label class="toggle text-base-content">
                            <input type="checkbox" value="synthwave" id="theme-switcher" class="theme-controller" />
                            <svg aria-label="sun" xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></g></svg>
                            <svg aria-label="moon" xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"><path d="M12 3a6 6 0 009 9 9 9 0 11-9-9Z"/></g></svg>
                        </label>
                    </div>
                </div>
            @endauth
        </div>
    </aside>

    {{-- Main content area --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Toast Notifications --}}
    <toasts class="toast toast-top toast-end z-50 space-y-2">
        @if(session('success'))
            <div id="toast-success" class="alert alert-success shadow-lg flex justify-between items-center gap-2">
                <span>{{ session('success') }}</span>
                <button class="btn btn-sm btn-ghost" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        @if(session('deleted'))
            <div id="toast-deleted" class="alert alert-warning shadow-lg flex justify-between items-center gap-2">
                <span>{{ session('deleted') }}</span>
                <button class="btn btn-sm btn-ghost" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class=" error-alert alert alert-error shadow-lg flex justify-between items-center gap-2 max-w-sm">
                    <span>{{ $error }}</span>
                    <button class="btn btn-sm btn-ghost" onclick="this.parentElement.remove()">✕</button>
                </div>
            @endforeach
        @endif
    </toasts>
</body>
</html>
