<dialog id="modal_role_edit" class="modal">
    <div class="modal-box w-full max-w-xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="text-2xl font-semibold mb-4">{{ __('Edit Role') }}</h3>

        <form method="POST" id="edit-role-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 px-1">
                {{-- Role Name --}}
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">{{ __('Name') }}</span>
                    </div>
                    <input type="text" class="input input-bordered w-full" name="name" id="edit-role-name" required />
                    <div class="label hidden text-error" id="edit-name-error-label">
                        <span class="label-text-alt text-sm break-words whitespace-normal" id="edit-name-error-text">
                            {{ __('This field is required') }}
                        </span>
                    </div>
                </label>

                {{-- Permissions (now optional) --}}
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">{{ __('Permissions') }}</span>
                    </div>
                    <select class="select select-bordered w-full min-h-50" multiple size="6"
                            id="edit-role-permissions" name="permissions[]">
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button class="btn btn-accent" id="edit-submit-btn" type="submit" disabled>{{ __('Update') }}</button>
            </div>
        </form>
    </div>
</dialog>
