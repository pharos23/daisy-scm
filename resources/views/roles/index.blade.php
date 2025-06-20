@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Button for creating a new role --}}
            <div class="flex justify-end">
                {{--
                @can('create-role')
                    <button class="btn btn-primary place-items-center m-5" onclick="window.location='{{ route('roles.create') }}'">Add New Role</button>
                @endcan
                --}}
                @can('create-user')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_role.showModal()">New</button>
                @endcan

                {{-- Popup (modal) para a criação de uma nova role --}}
                <dialog id="modal_role" class="modal">
                    <div class="modal-box w-full max-w-xl">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <h3 class="text-2xl font-semibold mb-4">Create New Role</h3>

                        <form action="{{ route('roles.store') }}" method="POST" id="role-form">
                            @csrf

                            <div class="grid grid-cols-1 gap-6 px-1">
                                {{-- Role Name --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Role Name</span>
                                    </div>
                                    <input type="text" class="input input-bordered w-full" placeholder="e.g., Manager"
                                           name="name" id="name" required />
                                    <div class="label hidden text-error" id="name-error-label">
                                        <span class="label-text-alt" id="name-error-text">This field is required.</span>
                                    </div>
                                </label>

                                {{-- Permissions --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Permissions</span>
                                    </div>
                                    <select class="select select-bordered w-full min-h-50" multiple size="6"
                                            aria-label="Permissions" id="permissions" name="permissions[]">
                                        @forelse ($permissions as $permission)
                                            <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @empty
                                            <option disabled>No permissions available</option>
                                        @endforelse
                                    </select>
                                    <div class="label hidden text-error mt-2" id="permissions-error-label">
                                        <span class="label-text-alt" id="permissions-error-text">Select at least one permission.</span>
                                    </div>
                                </label>
                            </div>

                            <div class="flex justify-end gap-2 mt-6">
                                <button class="btn btn-accent" id="submitBtn" type="submit" disabled>Create</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>

            {{-- Table --}}
            <div class="m-5">
                <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col" style="max-width:100px;">Role Name</th>
                    <th scope="col">Permissions</th>
                    <th scope="col" style="width: 250px;"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $role->name }}</td>
                        <td>
                            <ul class="p-2  flex flex-wrap gap-2">
                                @forelse ($role->permissions as $permission)
                                    <div class="badge badge-outline">{{ $permission->name }}</div>
                                @empty
                                @endforelse
                            </ul>
                        </td>
                        <td class="text-right whitespace-nowrap">
                            <div class="flex justify-end gap-2">
                                @if ($role->name != 'Super Admin')
                                    @can('edit-role')
                                        <button class="btn btn-primary btn-sm"
                                                onclick="openEditModal({{ $role->id }}, '{{ $role->name }}', @json($role->permissions->pluck('id')))">
                                            Edit
                                        </button>
                                    @endcan

                                    @can('delete-role')
                                        @if (!Auth::user()->hasRole($role->name))
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                  onsubmit="return confirm('Do you want to delete this role?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-error btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="3">
                    <span class="text-danger">
                        <strong>No Role Found!</strong>
                    </span>
                    </td>
                @endforelse
                </tbody>
            </table>
            </div>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    {{-- Edit Role Modal --}}
    <dialog id="modal_role_edit" class="modal">
        <div class="modal-box w-full max-w-xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-2xl font-semibold mb-4">Edit Role</h3>

            <form method="POST" id="edit-role-form">
                @csrf
                @method("PUT")

                <div class="grid grid-cols-1 gap-6 px-1">
                    {{-- Role Name --}}
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Role Name</span>
                        </div>
                        <input type="text" class="input input-bordered w-full" name="name" id="edit-role-name" required />
                        <div class="label hidden text-error" id="edit-name-error-label">
                            <span class="label-text-alt" id="edit-name-error-text">This field is required.</span>
                        </div>
                    </label>

                    {{-- Permissions --}}
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text">Permissions</span>
                        </div>
                        <select class="select select-bordered w-full min-h-50" multiple size="6"
                                id="edit-role-permissions" name="permissions[]">
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <div class="label hidden text-error mt-2" id="edit-permissions-error-label">
                            <span class="label-text-alt">Select at least one permission.</span>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button class="btn btn-accent" id="edit-submit-btn" type="submit" disabled>Update</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Edit Role Modal Function --}}
    <script>
        const editModal = document.getElementById('modal_role_edit');
        const editForm = document.getElementById('edit-role-form');
        const nameInput = document.getElementById('edit-role-name');
        const permissionsSelect = document.getElementById('edit-role-permissions');
        const submitBtn = document.getElementById('edit-submit-btn');

        function openEditModal(roleId, roleName, permissionIds) {
            // Fill form values
            nameInput.value = roleName;

            // Reset all options
            Array.from(permissionsSelect.options).forEach(opt => {
                opt.selected = permissionIds.includes(parseInt(opt.value));
            });

            // Set action URL
            editForm.action = `/roles/${roleId}`;

            // Show modal
            editModal.showModal();

            // Validate immediately
            validateEditForm();
        }

        function validateEditForm() {
            const isNameValid = nameInput.value.trim() !== '';
            const selectedPermissions = Array.from(permissionsSelect.selectedOptions);
            const isPermissionsValid = selectedPermissions.length > 0;

            document.getElementById('edit-name-error-label').classList.toggle('hidden', isNameValid);
            nameInput.classList.toggle('input-error', !isNameValid);

            document.getElementById('edit-permissions-error-label').classList.toggle('hidden', isPermissionsValid);
            permissionsSelect.classList.toggle('select-error', !isPermissionsValid);

            submitBtn.disabled = !(isNameValid && isPermissionsValid);
        }

        nameInput.addEventListener('input', validateEditForm);
        permissionsSelect.addEventListener('change', validateEditForm);
    </script>

    {{-- Data Validation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const permissionsSelect = document.getElementById('permissions');
            const submitBtn = document.getElementById('submitBtn');

            const nameError = document.getElementById('name-error-label');
            const permissionsError = document.getElementById('permissions-error-label');

            function validateName() {
                const isValid = nameInput.value.trim().length > 0;
                nameError.classList.toggle('hidden', isValid);
                nameInput.classList.toggle('input-error', !isValid);
                return isValid;
            }

            function validatePermissions() {
                const selected = Array.from(permissionsSelect.options).filter(opt => opt.selected);
                const isValid = selected.length > 0;
                permissionsError.classList.toggle('hidden', isValid);
                permissionsSelect.classList.toggle('select-error', !isValid);
                return isValid;
            }

            function validateAll() {
                const allValid = validateName() && validatePermissions();
                submitBtn.disabled = !allValid;
            }

            nameInput.addEventListener('input', validateAll);
            permissionsSelect.addEventListener('change', validateAll);

            validateAll();
        });
    </script>
@endsection
