@extends('layouts.app')
{{-- Blade to show user settings --}}
@section('content')
    <div class="bg-base min-h-screen flex justify-center items-center">
        <div class="card w-full max-w-2xl bg-base-200 shadow-xl border border-base-content/5">
            <div class="card-body">
                <h2 class="card-title text-2xl">{{__("Account Settings")}}</h2>

                <form method="POST" action="{{ route('userSettings.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Username (read-only) --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Username</span>
                        </label>
                        <div class="badge badge-outline p-4 text-base-content bg-base-100 select-none ml-1">
                            {{ Auth::user()->username }}
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="form-control">
                        <label for="name" class="label">
                            <span class="label-text font-semibold">{{__("Name")}}</span>
                        </label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', Auth::user()->name) }}"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                            placeholder={{__("Name")}}
                            required
                        />
                        @error('name')
                        <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password Change --}}
                    <div class="divider">{{__("Change Password")}}</div>

                    <div class="form-control">
                        <label for="current_password" class="label">
                            <span class="label-text font-semibold">{{__("Current Password")}}</span>
                        </label>
                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="input input-bordered w-full @error('current_password') input-error @enderror"
                            placeholder={{__("Current Password")}}
                            autocomplete="current-password"
                        />
                        @error('current_password')
                        <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="new_password" class="label">
                            <span class="label-text font-semibold">{{__("New Password")}}</span>
                        </label>
                        <input
                            id="new_password"
                            name="new_password"
                            type="password"
                            class="input input-bordered w-full @error('new_password') input-error @enderror"
                            placeholder="{{__('Newa')}} {{__('password')}}"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title={{__("Password req")}}
                            autocomplete="new-password"
                        />
                        @error('new_password')
                        <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label for="new_password_confirmation" class="label">
                            <span class="label-text font-semibold">{{__("Confirm New Password")}}</span>
                        </label>
                        <input
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            type="password"
                            class="input input-bordered w-full @error('new_password_confirmation') input-error @enderror"
                            placeholder={{__("Confirm New Password")}}
                            autocomplete="new-password"
                        />
                        @error('new_password_confirmation')
                        <span class="text-error text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="card-actions justify-end pt-4">
                        <button type="submit" class="btn btn-primary">{{__("Update")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
