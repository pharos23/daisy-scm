@extends('layouts.app')
{{--  Blade to show the admin dashboard  --}}
@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">
            <div class="m-5">
                <h1>Dashboard de Admin</h1>

                @canany(['create-role', 'edit-role', 'delete-role'])
                    <a class="btn btn-primary" href="{{ route('roles.index') }}"
                    >Manage Roles</a>
                @endcanany
                @canany(['create-user', 'edit-user', 'delete-user'])
                    <a class="btn btn-success" href="{{ route('users.index') }}"
                    >Manage Users</a>
                @endcanany
            </div>
        </div>
    </div>
@endsection
