@extends('layouts.app')
{{-- Blade to show dashboard. User can see different numerber of tabs, depending on role--}}
@section('content')
    @php
        $isAdmin = Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin');
        $defaultTab = $isAdmin ? 'admin' : 'contact';
    @endphp

    {{-- add alpine --}}
    @vite('resources/js/app.js') {{-- if Alpine is there already in app.js --}}

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="rounded-box border border-base-content/5 bg-base-200 w-[90%] h-[90%] p-4 relative"
             x-data="{ activeTab: '{{ $defaultTab }}' }"
        >

            {{-- Tabs --}}
            <div class="tabs tabs-border mb-4">
                @if($isAdmin)
                    <button
                        class="tab"
                        :class="{ 'tab-active': activeTab === 'admin' }"
                        @click="activeTab = 'admin'"
                    >
                        Admin
                    </button>
                    <button
                        class="tab"
                        :class="{ 'tab-active': activeTab === 'contact' }"
                        @click="activeTab = 'contact'"
                    >
                        Contacts
                    </button>
                @else
                    <button
                        class="tab"
                        :class="{ 'tab-active': activeTab === 'contact' }"
                        @click="activeTab = 'contact'"
                    >
                    </button>
                @endif
            </div>

            {{-- Tabs content --}}
            {{-- Admin dashboard --}}
            @if($isAdmin)
                <div x-show="activeTab === 'admin'" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Total Users")}}</div>
                            <div class="stat-value text-primary">{{ \App\Models\User::count() }}</div>
                            <div class="stat-desc">{{__("All time")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("News")}} {{__("Users")}}</div>
                            <div class="stat-value text-accent">
                                {{ \App\Models\User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfDay()])->count() }}
                            </div>
                            <div class="stat-desc">{{__("This month")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Roles")}}</div>
                            <div class="stat-value text-secondary">
                                {{ \Spatie\Permission\Models\Role::count() }}
                            </div>
                            <div class="stat-desc">{{__("Available")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">Top {{__("Role")}}</div>
                            <div class="stat-value">
                                {{
                                    DB::table('model_has_roles')
                                        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                        ->select('roles.name', DB::raw('count(*) as total'))
                                        ->groupBy('roles.name')
                                        ->orderByDesc('total')
                                        ->first()?->name ?? 'N/A'
                                }}
                            </div>
                            <div class="stat-desc">{{__("Most assigned")}}</div>
                        </div>
                    </div>

                    <div class="card bg-base-100 shadow overflow-x-auto">
                        <div class="card-body">
                            <h2 class="card-title">{{__("Recently Added Users")}}</h2>
                            <table class="table table-zebra w-full">
                                <thead>
                                <tr>
                                    <th>{{__("Name")}}</th>
                                    <th>Username</th>
                                    <th>{{__("Roles")}}</th>
                                    <th>{{__("Created")}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            @foreach($user->getRoleNames() as $role)
                                                <span class="badge badge-outline">{{ $role }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('users.index') }}" class="btn btn-primary">{{__("Manage")}} {{__("Users")}}</a>
                    </div>
                </div>
            @endif

            {{-- Contact Manager dashboard --}}
            <div x-show="activeTab === 'contact'" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="stat shadow place-items-center">
                        <div class="stat-title">{{__("Total")}} {{__("Contacts")}}</div>
                        <div class="stat-value text-primary">{{ DB::table('contacts')->count() }}</div>
                        <div class="stat-desc">{{__("All time")}}</div>
                    </div>
                    <div class="stat shadow place-items-center">
                        <div class="stat-title">{{__("News")}} {{__("Contacts")}}</div>
                        <div class="stat-value text-accent">
                            {{ DB::table('contacts')
                                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfDay()])
                                ->count() }}
                        </div>
                        <div class="stat-desc">{{__("This month")}}</div>
                    </div>
                    <div class="stat shadow place-items-center">
                        <div class="stat-title">{{__("Groups")}}</div>
                        <div class="stat-value text-secondary">
                            {{ DB::table('contacts')->distinct('grupo')->count('grupo') }}
                        </div>
                        <div class="stat-desc">{{__("Active groups")}}</div>
                    </div>
                </div>

                <div class="card bg-base-100 shadow overflow-x-auto">
                    <div class="card-body">
                        <h2 class="card-title">{{__("Recently Added Contacts")}}</h2>
                        <table class="table table-zebra w-full">
                            <thead>
                            <tr>
                                <th>Local</th>
                                <th>{{__("Group")}}</th>
                                <th>{{__("Name")}}</th>
                                <th>{{__("Cellphone")}}</th>
                                <th>{{__("Created")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(DB::table('contacts')->latest()->take(5)->get() as $contact)
                                <tr>
                                    <td>{{ $contact->local }}</td>
                                    <td>{{ $contact->grupo }}</td>
                                    <td>{{ $contact->nome }}</td>
                                    <td>{{ $contact->telemovel }}</td>
                                    <td>{{ \Carbon\Carbon::parse($contact->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('contacts.index') }}" class="btn btn-primary">{{__("Manage")}} {{__("Contacts")}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
