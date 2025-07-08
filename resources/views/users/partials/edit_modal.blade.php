<dialog id="modal_user_edit" class="modal">
    <div class="modal-box w-full max-w-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="text-2xl font-semibold mb-4">{{ __("Edit") }} {{ __("User") }}</h3>

        <form method="POST" id="edit-user-form">
            @csrf
            @method("PUT")

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Name") }}</span></div>
                    <input type="text" name="name" id="edit-name" class="input input-bordered w-full" required />
                    <div class="text-error text-sm hidden" id="edit-name-error">{{ __("validation.invalid_name") }}</div>
                </label>

                {{-- Username --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Username") }}</span></div>
                    <input type="text" name="username" id="edit-username" class="input input-bordered w-full" required />
                    <div class="text-error text-sm hidden" id="edit-username-error">{{ __("validation.invalid_username") }}</div>
                </label>

                {{-- Password --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Password") }}</span></div>
                    <input
                        type="password"
                        name="password"
                        id="edit-password"
                        placeholder="{{ __('validation.leave_blank') }}"
                        class="input input-bordered w-full"
                    />
                    <div class="text-error text-sm hidden" id="edit-password-error">{{ __("validation.invalid_password") }}</div>
                </label>

                {{-- Confirm Password --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __("Confirm Password") }}</span></div>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="edit-password-confirmation"
                        placeholder="{{ __('validation.leave_blank') }}"
                        class="input input-bordered w-full"
                    />
                    <div class="text-error text-sm hidden" id="edit-confirm-password-error">{{ __("validation.passwords_do_not_match") }}</div>
                </label>

                {{-- Roles --}}
                <div class="form-control w-full md:col-span-2">
                    <div class="label"><span class="label-text">{{ __("Roles") }}</span></div>
                    <select
                        id="edit-roles"
                        name="roles[]"
                        class="select select-bordered w-full min-h-20"
                        multiple
                        required
                    >
                        @foreach ($roles as $role)
                            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endif
                        @endforeach
                    </select>
                    <div class="label hidden text-error" id="edit-roles-error">
                        <span class="label-text-alt">{{ __("validation.select_at_least_one_role") }}</span>
                    </div>
                </div>

                {{-- Force password change --}}
                <div class="form-control md:col-span-2">
                    <div class="label">
                        <span class="label-text">{{ __('Force user to change password on next login') }}</span>
                    </div>
                    <input type="hidden" name="force_password_change" value="0" />
                    <input
                        type="checkbox"
                        name="force_password_change"
                        id="edit-force-password-change"
                        class="checkbox"
                        value="1"
                    />
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button class="btn btn-accent" id="edit-submit-btn" type="submit" disabled>{{ __("Update") }}</button>
            </div>
        </form>
    </div>
</dialog>
