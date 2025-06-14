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
                    <form action="{{ route('contacts.search') }}" method="GET">
                        <input type="search" class="grow" name="search" placeholder="Search" />
                    </form>
                </label>

                <!-- Botão para criar um novo contacto -->
                @can('create-contact')
                    <button class="btn btn-primary place-items-center m-5"
                            onclick="modal_new.showModal()">New</button>
                @endcan
                @cannot('create-contact')
                    <button class="btn btn-primary place-items-center m-5"
                            disabled="disabled">New</button>
                @endcannot


                <!-- Popup (modal) para a criação de um novo contacto -->
                <dialog id="modal_new" class="modal">
                    <div class="modal-box max-w-115">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>
                        <h3 class="text-lg font-bold">New Contact</h3>
                        <form action="{{ route('contacts.create') }}" method="POST" id="contact-form">
                            @csrf
                            @method('PUT')
                            <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
                                <div>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend">Local</legend>
                                        <input type="text" class="input" placeholder="My awesome page"
                                               name="local" id="local" value="{{ old('local') }}" required />
                                    </fieldset>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend">Grupo</legend>
                                        <input type="text" class="input" placeholder="My awesome page"
                                               name="grupo" id="grupo" value="{{ old('grupo') }}" required />
                                    </fieldset>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend">Nome</legend>
                                        <input type="text" class="input" placeholder="My awesome page"
                                               name="nome" id="nome" value="{{ old('nome') }}" required />
                                    </fieldset>
                                    <fieldset class="fieldset">
                                        <legend class="fieldset-legend">Telemóvel</legend>
                                        <input type="text" class="input" placeholder="My awesome page"
                                               name="telemovel" id="telemovel" value="{{ old('telemovel') }}" required />
                                    </fieldset>
                                </div>
                            </div>

                            <div class="flex justify-end gap-2 m-5">
                                <button class="btn btn-accent" type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </dialog>
            </div>

            <!-- Tabela -->
            <div class="m-5">
                <table class="table">
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
                    <td>{{ $contact->local }}</td>
                    <td>{{ $contact->grupo }}</td>
                    <td>{{ $contact->nome }}</td>
                    <td>{{ $contact->telemovel }}</td>
                    <th class="max-w-10">
                        <button class="btn" onclick="window.location='{{ route('contacts.show', ['id' => $contact->id]) }}'">Show</button>
                    </th>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>

            <div class="absolute bottom-0 center w-full p-5">
                {{ $contacts->links() }}
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
@endsection
