@extends('layouts.app')
<title>{{ __('Dashboard') }}</title>
@section('content')
    @vite('resources/js/pages/home.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="rounded-box border border-base-content/5 bg-base-200 w-[90%] h-[90%] p-4 relative">

            {{-- Show tabs only for Admins --}}
            @if ($isAdmin)
                <div class="tabs tabs-border mb-4">
                    <a
                        href="{{ route('home', ['tab' => 'admin']) }}"
                        class="tab {{ $activeTab === 'admin' ? 'tab-active' : '' }}"
                    >
                        Admin
                    </a>
                    <a
                        href="{{ route('home', ['tab' => 'contact']) }}"
                        class="tab {{ $activeTab === 'contact' ? 'tab-active' : '' }}"
                    >
                        {{ __("Contacts") }}
                    </a>
                </div>
            @endif

            {{-- Admin Dashboard --}}
            @if ($isAdmin && $activeTab === 'admin')
                <div class="space-y-6">
                    {{-- Admin cards/stats --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Total Users")}}</div>
                            <div class="stat-value text-info">{{ $adminStats['totalUsers'] }}</div>
                            <div class="stat-desc">{{__("All time")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("New Users")}}</div>
                            <div class="stat-value text-info">{{ $adminStats['newUsers'] }}</div>
                            <div class="stat-desc">{{__("This month")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Roles")}}</div>
                            <div class="stat-value text-info">{{ $adminStats['totalRoles'] }}</div>
                            <div class="stat-desc">{{__("Available")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Top Role")}}</div>
                            <div class="stat-value text-info">{{ $adminStats['topRole'] }}</div>
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
                                @foreach($adminStats['recentUsers'] as $user)
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
                        <form
                            action="{{ route('deploy') }}"
                            method="POST"
                            id="deployForm"
                            data-confirm-message="{{ __('UpdateConfirm') }}"
                        >
                            @csrf
                            <button type="submit" id="deployBtn" class="btn btn-warning">
                                <span id="deployText">{{ __('UpdateCode') }}</span>
                                <span id="deploySpinner" class="loading loading-spinner hidden"></span>
                            </button>
                        </form>

                        <a href="{{ route('users.index') }}" class="btn btn-primary">{{__("Manage")}} {{__("Users")}}</a>
                    </div>
                </div>
            @endif

            {{-- Contact Dashboard (default for non-admins, available for admins in tab) --}}
            @if ($activeTab === 'contact')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Total")}} {{__("Contacts")}}</div>
                            <div class="stat-value text-info">{{ $contactStats['totalContacts'] }}</div>
                            <div class="stat-desc">{{__("All time")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("New Contacts")}}</div>
                            <div class="stat-value text-info">{{ $contactStats['newContacts'] }}</div>
                            <div class="stat-desc">{{__("This month")}}</div>
                        </div>
                        <div class="stat shadow place-items-center">
                            <div class="stat-title">{{__("Groups")}}</div>
                            <div class="stat-value text-info">{{ $contactStats['totalGroups'] }}</div>
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
                                @foreach($contactStats['recentContacts'] as $contact)
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
            @endif
        </div>
    </div>
@endsection
