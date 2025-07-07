<dialog id="modal_user" class="modal">
    <div class="modal-box w-full max-w-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="text-2xl font-semibold mb-4">{{ __("Create New User") }}</h3>

        <form action="{{ route('users.store') }}" method="POST" id="user-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Name") }}</span></div>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        class="input input-bordered w-full"
                        placeholder="{{ __('Name') }}"
                        required
                        minlength="3"
                        maxlength="30"
                        pattern="^[A-Za-zÀ-ÿ' -]{3,50}$"
                        title="{{ __('validation.invalid_name') }}"
                    />
                    <div class="text-error text-sm hidden" id="name-error">{{ __("validation.name_required") }}</div>
                </label>

                {{-- Username --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Username") }}</span></div>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        class="input input-bordered w-full"
                        placeholder="{{ __('Username') }}"
                        required
                        minlength="3"
                        maxlength="30"
                        pattern="[A-Za-z][A-Za-z0-9\-]*"
                        title="{{ __('validation.invalid_username') }}"
                    />
                    <div class="text-error text-sm hidden" id="username-error">{{ __("validation.username_required") }}</div>
                </label>

                {{-- Password --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Password") }}</span></div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="input input-bordered w-full"
                        placeholder="********"
                        required
                        minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="{{ __('validation.password_strength') }}"
                    />
                    <div class="text-error text-sm hidden" id="password-error">{{ __("validation.password_required") }}</div>
                </label>

                {{-- Confirm Password --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Confirm Password") }}</span></div>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="input input-bordered w-full"
                        placeholder="********"
                        required
                    />
                    <div class="text-error text-sm hidden" id="confirm-password-error">{{ __("validation.passwords_do_not_match") }}</div>
                </label>

                {{-- Roles --}}
                <div class="form-control w-full md:col-span-2">
                    <div class="label"><span class="label-text">{{ __('Roles') }}</span></div>
                    <select
                        id="roles"
                        name="roles[]"
                        class="select select-bordered w-full min-h-20"
                        multiple
                        required
                    >
                        @forelse ($roles as $role)
                            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endif
                        @empty
                            <option disabled>{{ __("No roles available") }}</option>
                        @endforelse
                    </select>
                    <div class="label hidden text-error" id="roles-error">
                        <span class="label-text-alt">{{ __("validation.select_at_least_one_role") }}</span>
                    </div>
                </div>

                {{-- Force password change --}}
                <div class="form-control md:col-span-2">
                    <div class="label">
                        <span class="label-text">{{ __('Force user to change password on first login') }}</span>
                    </div>
                    <input type="hidden" name="force_password_change" value="0" />
                    <input
                        type="checkbox"
                        name="force_password_change"
                        class="checkbox"
                        value="1"
                        checked
                    />
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button class="btn btn-accent" id="submitBtn" type="submit" disabled>{{ __("Create") }}</button>
            </div>
        </form>
    </div>
</dialog>
