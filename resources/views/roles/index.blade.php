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
                                                onclick="window.location='{{ route('roles.edit', $role->id) }}'">
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
