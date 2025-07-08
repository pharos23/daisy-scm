<dialog id="modal_role" class="modal">
    <div class="modal-box w-full max-w-xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="text-2xl font-semibold mb-4">{{ __('Create Role') }}</h3>

        <form action="{{ route('roles.store') }}" method="POST" id="role-form">
            @csrf

            <div class="grid grid-cols-1 gap-6 px-1">
                {{-- Role Name --}}
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">{{ __('Name') }}</span>
                    </div>
                    <input type="text" class="input input-bordered w-full" placeholder="ex: Manager"
                           name="name" id="name" required />
                    <div class="label hidden text-error" id="name-error-label">
                        <span class="label-text-alt text-sm break-words whitespace-normal" id="name-error-text">
                            {{ __('This field is required') }}
                        </span>
                    </div>
                </label>

                {{-- Permissions --}}
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">{{ __('Permissions') }}</span>
                    </div>
                    <select class="select select-bordered w-full min-h-50" multiple size="6"
                            aria-label="Permissions" id="permissions" name="permissions[]">
                        @forelse ($permissions as $permission)
                            <option value="{{ $permission->id }}"
                                {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                {{ $permission->name }}
                            </option>
                        @empty
                            <option disabled>{{ __('No permissions available') }}</option>
                        @endforelse
                    </select>
                    <div class="label hidden text-error mt-2" id="permissions-error-label">
                        <span class="label-text-alt" id="permissions-error-text">{{ __('Select at least one permission') }}</span>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button class="btn btn-accent" id="submitBtn" type="submit" disabled>{{ __('Create') }}</button>
            </div>
        </form>
    </div>
</dialog>
