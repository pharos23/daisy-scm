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

                <!-- Popup (modal) para a criação de um novo contacto -->
                <dialog id="modal_user" class="modal">
                    <div class="modal-box max-w-115">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold">New User</h3>
                        <form action="{{ route('users.store') }}" method="POST" id="user-form">
                            @csrf

                            <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
                                <div>
                                    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
                                        <label class="input validator">
                                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <g
                                                    stroke-linejoin="round"
                                                    stroke-linecap="round"
                                                    stroke-width="2.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                >
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </g>
                                            </svg>
                                            <input
                                                type="text" placeholder="Name" name="name" id="name"
                                                pattern="[A-Za-z][A-Za-z0-9\-]*" minlength="3" maxlength="30"
                                                title="Only letters, numbers or dash"
                                                value="{{ old('name') }}" class="@error('name') is-invalid @enderror" required
                                            />
                                        </label>
                                        <div class="hidden" id="name_confirmation">
                                            <p id="name-error" style="color: red;"></p>
                                        </div>

                                        <label class="input validator">
                                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <g
                                                    stroke-linejoin="round"
                                                    stroke-linecap="round"
                                                    stroke-width="2.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                >
                                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </g>
                                            </svg>
                                            <input type="email" name="email" id="email" placeholder="mail@site.com"
                                                   value="{{ old('email') }}" class="@error('email') is-invalid @enderror" required />
                                        </label>
                                        <div class="hidden" id="email_confirmation">
                                            <p id="email-error" style="color: red;"></p>
                                        </div>

                                        <label class="input validator">
                                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <g
                                                    stroke-linejoin="round"
                                                    stroke-linecap="round"
                                                    stroke-width="2.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"
                                                    ></path>
                                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                            <input
                                                type="password" name="password" id="password"
                                                placeholder="Password" class="@error('password') is-invalid @enderror" required
                                                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must be more than 8 characters, including number, lowercase letter, uppercase letter"
                                            />
                                        </label>
                                        <p class="hidden">
                                            Must be more than 8 characters, including
                                            <br />At least one number <br />At least one lowercase letter <br />At least one uppercase letter
                                        </p>

                                        <label class="input validator">
                                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <g
                                                    stroke-linejoin="round"
                                                    stroke-linecap="round"
                                                    stroke-width="2.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"
                                                    ></path>
                                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                                </g>
                                            </svg>
                                            <input
                                                type="password" name="password_confirmation" id="password_confirmation"
                                                placeholder="Confirm Password" required
                                                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                title="Must be more than 8 characters, including number, lowercase letter, uppercase letter"
                                            />
                                        </label>
                                        <div class="hidden" id="confirmEmail">
                                            <p id="confirmPassword-feedback" style="color: red;"></p>
                                        </div>
                                    </fieldset>

                                    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
                                        <legend class="fieldset-legend text-sm">Roles</legend>
                                        <div class="col-md-6">
                                            <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                                                @forelse ($roles as $role)

                                                    @if ($role!='Super Admin')
                                                        <option class="text-sm" value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                            {{ $role }}
                                                        </option>
                                                    @else
                                                        @if (Auth::user()->hasRole('Super Admin'))
                                                            <option class="text-sm" value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                                {{ $role }}
                                                            </option>
                                                        @endif
                                                    @endif

                                                @empty

                                                @endforelse
                                            </select>
                                            @error('roles')
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
        const nameInput = document.getElementById("name");
        const emailInput = document.getElementById("email");
        const password = document.getElementById("password");
        const feedback = document.getElementById("confirmPassword-feedback");
        const confirmHint = document.getElementById("confirmHint");
        const submitBtn = document.getElementById("submitBtn");

        const confirmName = document.getElementById("name_confirmation");
        const confirmEmail = document.getElementById("email_confirmation");
        const confirmPassword = document.getElementById("password_confirmation");

        nameInput.addEventListener("input", validateName);
        emailInput.addEventListener("input", validateEmail);
        password.addEventListener("input", validatePassword);
        confirmPassword.addEventListener("input", validatePassword);

        function validateName() {
            const name = nameInput.value.trim();
            const nameError = document.getElementById('name-error');
            if (name.length < 3) {
                nameError.textContent = 'Name must be at least 3 characters.';
                confirmName.classList.remove("hidden");
                return false;
            } else if (name.length > 30) {
                nameError.textContent = 'Name cannot exceed 30 characters.';
                confirmName.classList.remove("hidden");
                return false;
            } else {
                nameError.textContent = '';
                return true;
            }
        }

        function validateEmail() {
            const email = emailInput.value.trim();
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailError.textContent = 'Please enter a valid email address.';
                confirmEmail.classList.remove("hidden");
                return false;
            } else {
                emailError.textContent = '';
                return true;
            }
        }

        function validatePassword() {
            const passwordValue = password.value;
            const confirmPasswordValue = confirmPassword.value;

            if (passwordValue !== confirmPasswordValue) {
                feedback.textContent = "Passwords do not match.";
                confirmHint.classList.remove("hidden");
                return false;
            } else {
                feedback.textContent = "";
                return true;
            }
        }

        function validateForm() {
            submitBtn.disabled = !(validateName() === true && validateEmail() === true && validatePassword() === true);
        }
    </script>
@endsection
