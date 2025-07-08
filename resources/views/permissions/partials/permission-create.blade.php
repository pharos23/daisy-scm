<dialog id="modal_permission" class="modal">
    <div class="modal-box w-full max-w-xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="text-2xl font-semibold mb-4">{{ __("Create") }} {{ __("Permission") }}</h3>

        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">{{ __("Name") }}</span>
                </div>
                <input type="text"
                       class="input input-bordered w-full"
                       name="name"
                       id="permission-name"
                       placeholder="ex: edit-user"
                       pattern="^[A-Za-z0-9_-]{3,30}$"
                       title="{{ __('validation.invalid_permission_name') }}"
                       minlength="3"
                       maxlength="30"
                       required />
                <div class="label hidden text-error" id="permission-error-label">
                    <span class="label-text-alt text-sm break-words whitespace-normal" id="permission-error-text">
                        {{ __('validation.invalid_permission_name') }}
                    </span>
                </div>
            </label>

            <div class="flex justify-end gap-2 mt-6">
                <button class="btn btn-accent" id="permission-submit" type="submit" disabled>{{ __("Create") }}</button>
            </div>
        </form>
    </div>
</dialog>
