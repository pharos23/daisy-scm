@extends('layouts.app')
{{--  Blade to show the user settings --}}
@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative p-6">
            <form method="POST" action="{{ route('userSettings.update') }}" class="p-6 mx-8 max-w-[600px] w-full h-full overflow-auto">
                @csrf
                @method('PUT')

                {{-- Username Display (readonly) --}}
                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-2">Username</legend>
                    <div class="input input-bordered bg-base-200 cursor-not-allowed" tabindex="-1" aria-disabled="true">
                        {{ Auth::user()->name }}
                    </div>
                </fieldset>

                {{-- Email --}}
                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-2">Email</legend>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="mail@site.com"
                        value="{{ old('email', Auth::user()->email) }}"
                        required
                        class="input input-bordered w-full @error('email') input-error @enderror"
                        title="Please enter a valid email address"
                        autocomplete="email"
                    />
                    @error('email')
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </fieldset>

                {{-- Password --}}
                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-2">Change Password</legend>

                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        placeholder="Current Password"
                        minlength="8"
                        class="input input-bordered w-full mb-3 @error('current_password') input-error @enderror"
                        title="Please enter your current password (min 8 characters)"
                        autocomplete="current-password"
                        {{-- Note: 'required' not enforced because password change is optional --}}
                    />
                    @error('current_password')
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror

                    <input
                        id="new_password"
                        name="new_password"
                        type="password"
                        placeholder="New Password"
                        minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Must be at least 8 characters and include a number, a lowercase letter, and an uppercase letter"
                        class="input input-bordered w-full mb-3 @error('new_password') input-error @enderror"
                        autocomplete="new-password"
                    />
                    @error('new_password')
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror

                    <input
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        type="password"
                        placeholder="Confirm New Password"
                        minlength="8"
                        class="input input-bordered w-full @error('new_password_confirmation') input-error @enderror"
                        autocomplete="new-password"
                    />
                    @error('new_password_confirmation')
                    <p class="text-error mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </fieldset>

                <button type="submit" class="btn btn-primary w-full">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
