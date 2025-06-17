@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            <!-- Cabeçalho da Tabela -->
            <div class="flex w-full flex-col lg:flex-row">
                <!-- Barra de Search -->
                <label class="input grow place-items-center m-5">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g
                            stroke-linejoin="round"
                            stroke-linecap="round"
                            stroke-width="2.5"
                            fill="none"
                            stroke="currentColor"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <form action="{{ route('users.search') }}" method="GET">
                        <input type="search" class="grow" name="search" placeholder="Search" />
                    </form>
                </label>

                <!-- Botão para criar um novo user -->
                {{-- @can('create-user')
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>
                @endcan --}}
                @can('create-user')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_user.showModal()">New</button>
                @endcan

                <!-- Popup (modal) para a criação de um novo user -->
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
                                    <input type="text" id="name" name="name"
                                           class="input input-bordered w-full"
                                           placeholder="e.g., johndoe"
                                           pattern="[A-Za-z][A-Za-z0-9\-]*"
                                           minlength="3" maxlength="30"
                                           title="Only letters, numbers or dash"
                                           required />
                                    <div class="label hidden text-error" id="name-error">
                                        <span class="label-text-alt">Name must be at least 3 characters (letters, numbers or dashes).</span>
                                    </div>
                                </label>

                                {{-- Email --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Email</span>
                                    </div>
                                    <input type="email" id="email" name="email"
                                           class="input input-bordered w-full"
                                           placeholder="mail@example.com"
                                           required />
                                    <div class="label hidden text-error" id="email-error">
                                        <span class="label-text-alt">Please enter a valid email address.</span>
                                    </div>
                                </label>

                                {{-- Password --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Password</span>
                                    </div>
                                    <input type="password" id="password" name="password"
                                           class="input input-bordered w-full"
                                           placeholder="********"
                                           minlength="8"
                                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                           title="Must include number, lowercase and uppercase letter"
                                           required />
                                    <div class="label hidden text-error" id="password-error">
                                        <span class="label-text-alt">Password must be at least 8 characters with a number, lowercase and uppercase letter.</span>
                                    </div>
                                </label>

                                {{-- Confirm Password --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Confirm Password</span>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="input input-bordered w-full"
                                           placeholder="********"
                                           minlength="8"
                                           required />
                                    <div class="label hidden text-error" id="confirm-password-error">
                                        <span class="label-text-alt">Passwords do not match.</span>
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

            </div>

            <!-- Tabela -->
            <div class="m-5">
                <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <ul>
                                @forelse ($user->getRoleNames() as $role)
                                    <li>{{ $role }}</li>
                                @empty
                                @endforelse
                            </ul>
                        </td>
                        <td class="flex gap-2">
                            @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                                @if (Auth::user()->hasRole('Super Admin'))
                                    <button class="btn btn-primary btn-sm" onclick="window.location='{{ route('users.edit', $user->id) }}'">Edit</button>
                                @endif
                            @else
                                @can('edit-user')
                                    <button class="btn btn-primary btn-sm" onclick="window.location='{{ route('users.edit', $user->id) }}'">Edit</button>
                                @endcan

                                @can('delete-user')
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                    @if (Auth::user()->id!=$user->id)
                                        <button type="submit" class="btn btn-error btn-sm"
                                                onclick="return confirm('Do you want to delete this user?');">Delete</button>
                                    @endif
                                        </form>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @empty
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>No User Found!</strong>
                        </span>
                    </td>
                @endforelse
                </tbody>
            </table>
            </div>

            <!-- Paginação -->
            <div class="absolute bottom-0 center w-full p-5">
                {{ $users->links() }}
            </div>
        </div>
    </div>

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
