@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            <!-- Button for creating a new role -->
            <div class="flex justify-end">
                {{--
                @can('create-role')
                    <button class="btn btn-primary place-items-center m-5" onclick="window.location='{{ route('roles.create') }}'">Add New Role</button>
                @endcan
                --}}
                @can('create-user')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_role.showModal()">New</button>
                @endcan

                <!-- Popup (modal) para a criação de uma nova role -->
                <dialog id="modal_role" class="modal">
                    <div class="modal-box max-w-115">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold">New User</h3>
                        <form action="{{ route('roles.store') }}" method="POST" id="user-form">
                            @csrf

                            <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
                                <div>
                                    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
                                        <legend class="fieldset-legend">Name</legend>
                                        <input type="text" class="input" placeholder="The role's name" name="name" id="name" required />
                                        <div class="hidden" id="name_confirmation">
                                            <p id="name-error" style="color: red;"></p>
                                        </div>
                                    </fieldset>

                                    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
                                        <legend class="fieldset-legend text-sm">Permissions</legend>
                                        <div class="col-md-6">
                                            <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                                                @forelse ($permissions as $permission)
                                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                                        {{ $permission->name }}
                                                    </option>
                                                @empty

                                                @endforelse
                                            </select>
                                            @error('permissions')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 m-5">
                                <button class="btn btn-accent" id="submitBtn" disabled type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>

            <!-- Table -->
            <div class="m-5">
                <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col" style="max-width:100px;">Role Name</th>
                    <th scope="col">Permissions</th>
                    <th scope="col" style="width: 250px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $role->name }}</td>
                        <td>
                            <ul>
                                @forelse ($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @empty
                                @endforelse
                            </ul>
                        </td>
                        <td class="flex gap-2">
                            @if ($role->name!='Super Admin')
                                @can('edit-role')
                                    <button class="btn btn-primary btn-sm" onclick="window.location='{{ route('roles.edit', $role->id) }}'">Edit</button>
                                @endcan

                                @can('delete-role')
                                        @if ($role->name!=Auth::user()->hasRole($role->name))
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-error btn-sm"
                                                        onclick="return confirm('Do you want to delete this role?');">Delete</button>
                                            </form>
                                        @endif
                                    @endcan
                            @endif
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

            <!-- Pagination -->
            <div class="absolute bottom-0 center w-full p-5">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <script>
        const nameInput = document.getElementById("name");
        const submitBtn = document.getElementById("submitBtn");

        const confirmName = document.getElementById("name_confirmation");

        nameInput.addEventListener("input", validateName);

        function validateName() {
            const name = nameInput.value.trim();
            const nameError = document.getElementById('name-error');
            if (name.length < 3) {
                nameError.textContent = 'Name must be at least 3 characters.';
                confirmName.classList.remove("hidden");
                submitBtn.disabled = true;
                return false;
            } else if (name.length > 30) {
                nameError.textContent = 'Name cannot exceed 30 characters.';
                confirmName.classList.remove("hidden");
                submitBtn.disabled = true;
                return false;
            } else {
                nameError.textContent = '';
                submitBtn.disabled = false
                return true;
            }
        }
    </script>
@endsection
