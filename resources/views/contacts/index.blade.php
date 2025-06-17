@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            <!-- Cabeçalho da Tabela -->
            <div class="flex w-full justify-between">
                <!-- Search and filter inputs -->
                <div class="flex gap-4 m-5">
                    <input type="text" id="searchInput" placeholder="Search..." class="input input-bordered" />

                    <select id="filterLocal" class="select select-bordered">
                        <option value="">All Locals</option>
                        <option value="Hospital Prelada">Hospital Prelada</option>
                        <option value="Spec">Spec</option>
                        <option value="Conde de Ferreira">Conde de Ferreira</option>
                    </select>

                    <select id="filterGroup" class="select select-bordered">
                        <option value="">All Groups</option>
                        <option value="DSI">DSI</option>
                        <option value="OPS">OPS</option>
                        <option value="Transporte">Transporte</option>
                    </select>
                </div>

                <!-- Botão para criar um novo contacto -->
                @can('create-contact')
                    <button class="btn btn-primary place-items-center m-5"
                            onclick="modal_new.showModal()">Novo</button>
                @endcan
                @cannot('create-contact')
                    <button class="btn btn-primary place-items-center m-5"
                            disabled="disabled">New</button>
                @endcannot

                {{-- Popup (modal) para a criação de um novo contacto --}}
                <dialog id="modal_new" class="modal">
                    <div class="modal-box w-full max-w-xl">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <h3 class="text-2xl font-semibold mb-4">Novo Contacto</h3>

                        <form action="{{ route('contacts.create') }}" method="POST" id="contact-form">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Local --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Local</span>
                                    </div>
                                    <select class="select select-bordered w-full" name="local" id="local" required>
                                        <option disabled selected>Escolha o Local</option>
                                        <option>Hospital Prelada</option>
                                        <option>Spec</option>
                                        <option>Conde de Ferreira</option>
                                    </select>
                                    <div class="label hidden text-error" id="local-error">
                                        <span class="label-text-alt">Selecione um local.</span>
                                    </div>
                                </label>

                                {{-- Grupo --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Grupo</span>
                                    </div>
                                    <select class="select select-bordered w-full" name="grupo" id="grupo" required>
                                        <option disabled selected>Escolha o grupo</option>
                                        <option>DSI</option>
                                        <option>OPS</option>
                                        <option>Transporte</option>
                                    </select>
                                    <div class="label hidden text-error" id="grupo-error">
                                        <span class="label-text-alt">Selecione um grupo.</span>
                                    </div>
                                </label>

                                {{-- Nome --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Nome</span>
                                    </div>
                                    <input type="text" class="input input-bordered w-full" placeholder="Nome"
                                           name="nome" id="nome" value="{{ old('nome') }}" required />
                                    <div class="label hidden text-error" id="nome-error">
                                        <span class="label-text-alt">Nome é obrigatório.</span>
                                    </div>
                                </label>

                                {{-- Telemóvel --}}
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Telemóvel</span>
                                    </div>
                                    <input type="text" class="input input-bordered w-full" placeholder="Telemóvel"
                                           name="telemovel" id="telemovel" value="{{ old('telemovel') }}" pattern="^\d{9}$" required />
                                    <div class="label hidden text-error" id="telemovel-error">
                                        <span class="label-text-alt">Insira um número de 9 dígitos.</span>
                                    </div>
                                </label>
                            </div>

                            <div class="flex justify-end gap-2 mt-6">
                                <button class="btn btn-accent" id="submitBtn" type="submit" disabled>Criar</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>

            <!-- Tabela -->
            <div class="m-5">
                <table class="table" id="contactsTable">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th>Local</th>
                        <th>Grupo</th>
                        <th>Nome</th>
                        <th>Telemóvel</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- rows -->
                    @foreach($contacts as $contact)
                        <tr>
                            <td class="local">{{ $contact->local }}</td>
                            <td class="group">{{ $contact->grupo }}</td>
                            <td class="name">{{ $contact->nome }}</td>
                            <td class="phone">{{ $contact->telemovel }}</td>
                            <th class="max-w-10">
                                <button class="btn" onclick="window.location='{{ route('contacts.show', ['id' => $contact->id]) }}'">Show</button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="absolute bottom-0 center w-full p-5">
                {{ $contacts->appends(request()->except('page'))->links() }}
            </div>
        </div>

        <!-- Avisos -->
        <div class="toast toast-top toast-end">
            @if(session('success'))
                <div class="alert alert-success" id="success-message">
                    <span>Contact created successfully</span>
                </div>
            @endif
            @if(session('deleted'))
                <div class="alert alert-error" id="success-message">
                    <span>Contact deleted successfully</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Temporizador para os Avisos -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 3000); // 5000 milliseconds = 5 seconds
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filterLocal = document.getElementById('filterLocal');
            const filterGroup = document.getElementById('filterGroup');
            const table = document.getElementById('contactsTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const localFilter = filterLocal.value;
                const groupFilter = filterGroup.value;

                rows.forEach(row => {
                    const local = row.querySelector('.local').textContent.toLowerCase();
                    const group = row.querySelector('.group').textContent.toLowerCase();
                    const name = row.querySelector('.name').textContent.toLowerCase();
                    const phone = row.querySelector('.phone').textContent.toLowerCase();

                    // Check search text matches any column (name, phone, local, group)
                    const matchesSearch =
                        name.includes(searchTerm) ||
                        phone.includes(searchTerm) ||
                        local.includes(searchTerm) ||
                        group.includes(searchTerm);

                    // Check filters
                    const matchesLocal = !localFilter || local === localFilter.toLowerCase();
                    const matchesGroup = !groupFilter || group === groupFilter.toLowerCase();

                    if (matchesSearch && matchesLocal && matchesGroup) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Event listeners
            searchInput.addEventListener('input', filterTable);
            filterLocal.addEventListener('change', filterTable);
            filterGroup.addEventListener('change', filterTable);
        });
    </script>

    <script>
        function calculateItemsPerPage() {
            const itemHeight = 100; // estimated height of each contact item in pixels
            const containerPadding = 200; // account for header, footer, margins, etc.

            const availableHeight = window.innerHeight - containerPadding;
            const perPage = Math.floor(availableHeight / itemHeight);

            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            window.location.href = url.toString();
        }

        // Only redirect if perPage is not set (to avoid infinite reloads)
        if (!new URLSearchParams(window.location.search).has('perPage')) {
            window.addEventListener('load', calculateItemsPerPage);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contact-form');
            const submitBtn = document.getElementById('submitBtn');

            const fields = {
                local: document.getElementById('local'),
                grupo: document.getElementById('grupo'),
                nome: document.getElementById('nome'),
                telemovel: document.getElementById('telemovel')
            };

            const errors = {
                local: document.getElementById('local-error'),
                grupo: document.getElementById('grupo-error'),
                nome: document.getElementById('nome-error'),
                telemovel: document.getElementById('telemovel-error')
            };

            function validateField(field, errorElement, validatorFn) {
                const isValid = validatorFn(field);
                field.classList.toggle('input-error', !isValid);
                errorElement.classList.toggle('hidden', isValid);
                return isValid;
            }

            function validateForm() {
                const isLocalValid = validateField(fields.local, errors.local, f => f.value !== 'Escolha o Local');
                const isGrupoValid = validateField(fields.grupo, errors.grupo, f => f.value !== 'Escolha o grupo');
                const isNomeValid = validateField(fields.nome, errors.nome, f => f.value.trim().length > 0);
                const isTelemovelValid = validateField(fields.telemovel, errors.telemovel, f => /^\d{9}$/.test(f.value));
                submitBtn.disabled = !(isLocalValid && isGrupoValid && isNomeValid && isTelemovelValid);
            }

            Object.values(fields).forEach(field => {
                field.addEventListener('input', validateForm);
                field.addEventListener('change', validateForm);
            });

            validateForm(); // initial state
        });
    </script>
@endsection
