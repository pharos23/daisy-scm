@extends('layouts.app')

@section('content')
    @vite('resources/js/pages/contacts.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Table Header --}}
            <div class="flex w-full justify-between">
                {{-- Search and filter inputs --}}
                <div class="flex gap-4 m-5">
                    <input type="text" id="searchInput" placeholder="{{ __('Search') }} {{ __('Contacts') }}..." class="input input-bordered" />

                    <select id="filterLocal" class="select select-bordered">
                        <option value="">{{ __('AllLocals') }}</option>
                        <option value="Hospital Prelada">Hospital Prelada</option>
                        <option value="Spec">Spec</option>
                        <option value="Conde de Ferreira">Conde de Ferreira</option>
                    </select>

                    <select id="filterGroup" class="select select-bordered">
                        <option value="">{{ __('AllGroups') }}</option>
                        <option value="DSI">DSI</option>
                        <option value="OPS">OPS</option>
                        <option value="Transporte">Transporte</option>
                    </select>
                </div>

                {{-- Buttons Section --}}
                <buttons class="flex justify-end gap-4 m-5">
                    {{-- Import button with select file field --}}
                    @hasanyrole('admin|superadmin')
                    <form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
                        @csrf

                        <input type="file" name="file" required class="file-input file-input-bordered file-input w-full max-w-xs" />

                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">
                                {{ __('Import') }}
                            </button>
                        </div>
                    </form>

                    {{-- Export button --}}
                    <button class="btn btn-success" onclick="window.location.href='{{ route('contacts.export') }}'">
                        {{ __('Export') }}
                    </button>
                    @endhasanyrole

                    {{-- New Contact Button --}}
                    @can('create-contact')
                        <button class="btn btn-primary place-items-center"
                                onclick="modal_new.showModal()">{{ __('New') }}</button>
                    @endcan
                    @cannot('create-contact')
                        <button class="btn btn-primary place-items-center"
                                disabled="disabled">{{ __('New') }}</button>
                    @endcannot
                </buttons>
            </div>

            {{-- Table --}}
            <div class="m-5">
                <table class="table table-zebra table-md w-full" id="contactsTable">
                    <thead class="bg-base-200 text-base-content">
                    <tr>
                        <th>{{ __('Local') }}</th>
                        <th>{{ __('Group') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Cellphone') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td class="local">{{ $contact->local }}</td>
                            <td class="group">{{ $contact->grupo }}</td>
                            <td class="name">{{ $contact->nome }}</td>
                            <td class="phone">{{ $contact->telemovel }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline"
                                        onclick="window.location='{{ route('contacts.show', ['id' => $contact->id]) }}'">
                                    {{ __('More') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                <div class="pagination">
                    {{ $contacts->appends(request()->except('page'))->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- New Contact Modal --}}
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
@endsection
