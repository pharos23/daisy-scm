@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">

        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{--
            {{ __('You are logged in!') }}

            <p>This is your application dashboard.</p>
            @canany(['create-role', 'edit-role', 'delete-role'])
                <a class="btn btn-primary" href="{{ route('roles.index') }}">
                    <i class="bi bi-person-fill-gear"></i> Manage Roles</a>
            @endcanany
            @canany(['create-user', 'edit-user', 'delete-user'])
                <a class="btn btn-success" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> Manage Users</a>
            @endcanany
            @canany(['create-contact', 'edit-contact', 'delete-contact'])
                <a class="btn btn-warning" href="{{ route('contacts') }}">
                    <i class="bi bi-bag"></i> Manage Contacts</a>
            @endcanany
            @can(['view-product'])
                <a class="btn btn-warning" href="{{ route('contacts') }}">
                    <i class="bi bi-bag"></i> View Contacts</a>
            @endcan
            <p>&nbsp;</p>
            --}}

            <div class="flex flex-wrap justify-center m-5">
                <div class="stats shadow">
                    <div class="stat place-items-center">
                        <div class="stat-title">Role</div>
                        <div class="stat-value">{{ Auth::user()->getRoleNames()->first() }}</div>
                        <div class="stat-desc">Maybe Important!</div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title">Contacts</div>
                        <div class="stat-value">{{ DB::table('contacts')->count() }}</div>
                        <div class="stat-desc">More than last month!</div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title">New Contacts</div>
                        <div class="stat-value">{{ DB::table('contacts')
                            ->whereBetween('created_at', [
                                now()->subWeek()->startOfWeek(),
                                now()->subWeek()->today()])
                                ->count() }}
                        </div>
                        <div class="stat-desc">This Week!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
