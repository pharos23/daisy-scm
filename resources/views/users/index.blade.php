@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Table Heading --}}
            <div class="flex w-full justify-between">
                {{-- Search + Role Filter --}}
                <div class="flex gap-4 m-5">
                    <input type="text" id="userSearch" placeholder="Search by name or email" class="input input-bordered w-full max-w-xs" />

                    <select id="roleFilter" class="select select-bordered max-w-xs">
                        <option value="">All Roles</option>
                        @foreach($roles as $role) {{-- Ensure $roles = Role::pluck('name') or similar --}}
                        <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Botão para criar um novo user --}}
                @can('create-user')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_user.showModal()">New</button>
                @endcan
            </div>

            {{-- Popup (modal) para a criação de um novo user --}}
            <dialog id="modal_user" class="modal">
                <div class="modal-box w-full max-w-2xl">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>

                    <h3 class="text-2xl font-semibold mb-4">Create New User</h3>

                    <form action="{{ route('users.store') }}" method="POST" id="user-form">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Name</span>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <input type="text" id="name" name="name"
                                           class="input input-bordered w-full"
                                           placeholder="e.g., johndoe"
                                           pattern="[A-Za-z][A-Za-z0-9\-]*"
                                           minlength="3" maxlength="30"
                                           title="Only letters, numbers or dash"
                                           required />
                                    <div class="text-error text-sm hidden" id="name-error">
                                        Name must be at least 3 characters (letters, numbers or dashes).
                                    </div>
                                </div>
                            </label>


                            {{-- Email --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Email</span>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <input type="email" id="email" name="email"
                                           class="input input-bordered w-full"
                                           placeholder="mail@example.com"
                                           required />
                                    <div class="text-error text-sm hidden" id="email-error">
                                        Please enter a valid email address.
                                    </div>
                                </div>
                            </label>

                            {{-- Password --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Password</span>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <input type="password" id="password" name="password"
                                           class="input input-bordered w-full"
                                           placeholder="********"
                                           minlength="8"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                           title="Must include number, lowercase and uppercase letter"
                                           required />
                                    <div class="text-error text-sm hidden" id="password-error">
                                        Password must be at least 8 characters with a number, lowercase and uppercase letter.
                                    </div>
                                </div>
                            </label>

                            {{-- Confirm Password --}}
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Confirm Password</span>
                                </div>
                                <div class="flex flex-col space-y-1">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="input input-bordered w-full"
                                           placeholder="********"
                                           minlength="8"
                                           required />
                                    <div class="text-error text-sm hidden" id="confirm-password-error">
                                        Passwords do not match.
                                    </div>
                                </div>
                            </label>


                            {{-- Roles --}}
                            <div class="form-control w-full md:col-span-2">
                                <div class="label">
                                    <span class="label-text">Roles</span>
                                </div>
                                <select id="roles" name="roles[]" class="select select-bordered w-full min-h-20" multiple required>
                                    @forelse ($roles as $role)
                                        @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endif
                                    @empty
                                        <option disabled>No roles available</option>
                                    @endforelse
                                </select>
                                <div class="label hidden text-error" id="roles-error">
                                    <span class="label-text-alt">Select at least one role.</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <button class="btn btn-accent" id="submitBtn" disabled type="submit">Create</button>
                        </div>
                    </form>
                </div>
            </dialog>

            {{-- Table --}}
            <div class="m-5">
                <table class="table table-zebra table-sm w-full" id="usersTable">
                    <thead class="bg-base-200 text-base-content">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="name">{{ $user->name }}</td>
                            <td class="email">{{ $user->email }}</td>
                            <td class="roles">
                                <ul>
                                    @forelse ($user->getRoleNames() as $role)
                                        <div class="badge badge-outline">{{ $role }}</div>
                                    @empty
                                        <li class="text-gray-400 italic">No role</li>
                                    @endforelse
                                </ul>
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2">
                                    @php $isSuperAdmin = in_array('Super Admin', $user->getRoleNames()->toArray()); @endphp

                                    @if ($isSuperAdmin)
                                        @if (Auth::user()->hasRole('Super Admin'))
                                            <button
                                                class="btn btn-sm btn-primary open-edit-user"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-roles='@json($user->getRoleNames())'>
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-error" disabled="disabled">Delete</button>
                                        @endif
                                    @else
                                        @can('edit-user')
                                            <button
                                                class="btn btn-sm btn-primary open-edit-user"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-roles='@json($user->getRoleNames())'>
                                                Edit
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary" disabled="disabled">Edit</button>
                                        @endcan

                                        @can('delete-user')
                                            @if (Auth::user()->id !== $user->id)
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-error">Delete</button>
                                                </form>
                                                @else
                                                    <button class="btn btn-sm btn-error" disabled="disabled">Delete</button>
                                            @endif
                                            @else
                                                <button class="btn btn-sm btn-error" disabled="disabled">Delete</button>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-error font-semibold">No User Found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- Search Function --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById('userSearch');
            const roleFilter = document.getElementById('roleFilter');
            const rows = document.querySelectorAll('#usersTable tbody tr');

            function filterTable() {
                const search = searchInput.value.toLowerCase();
                const role = roleFilter.value.toLowerCase();

                rows.forEach(row => {
                    const name = row.querySelector('.name')?.textContent.toLowerCase() ?? '';
                    const email = row.querySelector('.email')?.textContent.toLowerCase() ?? '';
                    const roles = row.querySelector('.roles')?.textContent.toLowerCase() ?? '';

                    const matchesSearch = name.includes(search) || email.includes(search);
                    const matchesRole = !role || roles.includes(role);

                    row.style.display = matchesSearch && matchesRole ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            roleFilter.addEventListener('change', filterTable);
        });
    </script>

    {{-- Edit User Modal --}}
    <dialog id="modal_user_edit" class="modal">
        <div class="modal-box w-full max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-2xl font-semibold mb-4">Edit User</h3>

            <form method="POST" id="edit-user-form">
                @csrf
                @method("PUT")

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name --}}
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text">Name</span></div>
                        <input type="text" name="name" id="edit-name" class="input input-bordered w-full" required />
                        <div class="text-error text-sm hidden" id="edit-name-error">Invalid name.</div>
                    </label>

                    {{-- Email --}}
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text">Email</span></div>
                        <input type="email" name="email" id="edit-email" class="input input-bordered w-full" required />
                        <div class="text-error text-sm hidden" id="edit-email-error">Invalid email.</div>
                    </label>

                    {{-- Password --}}
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text">Password (leave blank to keep current)</span></div>
                        <input type="password" name="password" id="edit-password" class="input input-bordered w-full" />
                        <div class="text-error text-sm hidden" id="edit-password-error">Invalid password.</div>
                    </label>

                    {{-- Confirm Password --}}
                    <label class="form-control w-full">
                        <div class="label"><span class="label-text">Confirm Password</span></div>
                        <input type="password" name="password_confirmation" id="edit-password-confirmation" class="input input-bordered w-full" />
                        <div class="text-error text-sm hidden" id="edit-confirm-password-error">Passwords don't match.</div>
                    </label>

                    {{-- Roles --}}
                    <div class="form-control w-full md:col-span-2">
                        <div class="label"><span class="label-text">Roles</span></div>
                        <select id="edit-roles" name="roles[]" class="select select-bordered w-full min-h-20" multiple required>
                            @foreach ($roles as $role)
                                @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="label hidden text-error" id="edit-roles-error">
                            <span class="label-text-alt">Select at least one role.</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="submit" id="edit-submit-btn" class="btn btn-accent" disabled>Update</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Edit User Modal Function --}}
    <script>
        document.querySelectorAll('.open-edit-user').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const email = btn.dataset.email;
                const roles = JSON.parse(btn.dataset.roles);

                openEditUserModal(id, name, email, roles);
            });
        });


        const editModal = document.getElementById('modal_user_edit');
        const editForm = document.getElementById('edit-user-form');

        const editName = document.getElementById('edit-name');
        const editEmail = document.getElementById('edit-email');
        const editPassword = document.getElementById('edit-password');
        const editPasswordConfirm = document.getElementById('edit-password-confirmation');
        const editRoles = document.getElementById('edit-roles');
        const editSubmitBtn = document.getElementById('edit-submit-btn');

        function openEditUserModal(id, name, email, roles) {
            editForm.action = `/users/${id}`;
            editName.value = name;
            editEmail.value = email;
            editPassword.value = '';
            editPasswordConfirm.value = '';

            Array.from(editRoles.options).forEach(opt => {
                opt.selected = roles.includes(opt.value);
            });

            validateEditForm();
            editModal.showModal();
        }

        function validateEditForm() {
            const nameValid = editName.value.trim().length >= 3;
            const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(editEmail.value);
            const rolesValid = Array.from(editRoles.selectedOptions).length > 0;

            const password = editPassword.value;
            const passwordValid = password === '' || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/.test(password);
            const confirmValid = password === editPasswordConfirm.value;

            document.getElementById('edit-name-error').classList.toggle('hidden', nameValid);
            document.getElementById('edit-email-error').classList.toggle('hidden', emailValid);
            document.getElementById('edit-password-error').classList.toggle('hidden', passwordValid);
            document.getElementById('edit-confirm-password-error').classList.toggle('hidden', confirmValid);
            document.getElementById('edit-roles-error').classList.toggle('hidden', rolesValid);

            editSubmitBtn.disabled = !(nameValid && emailValid && passwordValid && confirmValid && rolesValid);
        }

        [editName, editEmail, editPassword, editPasswordConfirm, editRoles].forEach(el =>
            el.addEventListener('input', validateEditForm)
        );
    </script>

    {{-- Validation Function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const rolesSelect = document.getElementById('roles');
            const submitBtn = document.getElementById('submitBtn');

            const nameError = document.getElementById('name-error');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            const confirmPasswordError = document.getElementById('confirm-password-error');
            const rolesError = document.getElementById('roles-error');

            function validateName() {
                const isValid = nameInput.value.trim().length >= 3 && /^[A-Za-z][A-Za-z0-9\-]*$/.test(nameInput.value);
                nameError.classList.toggle('hidden', isValid);
                nameInput.classList.toggle('input-error', !isValid);
                return isValid;
            }

            function validateEmail() {
                const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
                emailError.classList.toggle('hidden', isValid);
                emailInput.classList.toggle('input-error', !isValid);
                return isValid;
            }

            function validatePassword() {
                const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
                const isValid = pattern.test(passwordInput.value);
                passwordError.classList.toggle('hidden', isValid);
                passwordInput.classList.toggle('input-error', !isValid);
                return isValid;
            }

            function validatePasswordConfirmation() {
                const isValid = passwordConfirmInput.value === passwordInput.value && passwordConfirmInput.value.length > 0;
                confirmPasswordError.classList.toggle('hidden', isValid);
                passwordConfirmInput.classList.toggle('input-error', !isValid);
                return isValid;
            }

            function validateRoles() {
                const selected = Array.from(rolesSelect.options).filter(opt => opt.selected);
                const isValid = selected.length > 0;
                rolesError.classList.toggle('hidden', isValid);
                rolesSelect.classList.toggle('select-error', !isValid);
                return isValid;
            }

            function validateAll() {
                const allValid = [
                    validateName(),
                    validateEmail(),
                    validatePassword(),
                    validatePasswordConfirmation(),
                    validateRoles()
                ].every(Boolean);

                submitBtn.disabled = !allValid;
            }

            nameInput.addEventListener('input', validateAll);
            emailInput.addEventListener('input', validateAll);
            passwordInput.addEventListener('input', validateAll);
            passwordConfirmInput.addEventListener('input', validateAll);
            rolesSelect.addEventListener('change', validateAll);

            validateAll();
        });
    </script>
@endsection
