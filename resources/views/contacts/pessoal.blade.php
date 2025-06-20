<form action="{{ route('contacts.update', $contact->id) }}" method="POST" id="contact-form">
    {{--  Blade to show the "Pessoal" tab of the selected contact --}}
    @csrf
    @method('PUT')

    @can('edit-contact')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

            {{-- Local --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Local</span></div>
                <select class="select select-bordered w-full" name="local" id="local" required>
                    <option disabled {{ $contact->local ? '' : 'selected' }}>Escolha o Local</option>
                    <option {{ $contact->local === 'Hospital Prelada' ? 'selected' : '' }}>Hospital Prelada</option>
                    <option {{ $contact->local === 'Spec' ? 'selected' : '' }}>Spec</option>
                    <option {{ $contact->local === 'Conde de Ferreira' ? 'selected' : '' }}>Conde de Ferreira</option>
                </select>
            </label>

            {{-- Grupo --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Grupo</span></div>
                <select class="select select-bordered w-full" name="grupo" id="grupo" required>
                    <option disabled {{ $contact->grupo ? '' : 'selected' }}>Escolha o grupo</option>
                    <option {{ $contact->grupo === 'DSI' ? 'selected' : '' }}>DSI</option>
                    <option {{ $contact->grupo === 'OPS' ? 'selected' : '' }}>OPS</option>
                    <option {{ $contact->grupo === 'Transporte' ? 'selected' : '' }}>Transporte</option>
                </select>
            </label>

            {{-- Nome --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Nome</span></div>
                <input type="text" name="nome" id="nome" value="{{ $contact->nome }}"
                       placeholder="Nome" class="input input-bordered w-full" required>
            </label>

            {{-- Telemóvel --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Telemóvel</span></div>
                <input type="text" name="telemovel" id="telemovel" value="{{ $contact->telemovel }}"
                       placeholder="Telemóvel" class="input input-bordered w-full" required>
            </label>

            {{-- Extensão --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Extensão</span></div>
                <input type="text" name="extensao" id="extensao" value="{{ $contact->extensao }}"
                       placeholder="Extensão" class="input input-bordered w-full">
            </label>

            {{-- Funcionalidades --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Funcionalidades</span></div>
                <input type="text" name="funcionalidades" id="funcionalidades" value="{{ $contact->funcionalidades }}"
                       placeholder="Funcionalidades" class="input input-bordered w-full">
            </label>

            {{-- Ativação --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ativação/Reativação</span></div>
                <input type="date" name="ativacao" id="ativacao" value="{{ $contact->ativacao }}"
                       class="input input-bordered w-full">
            </label>

            {{-- Desativação --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Desativação</span></div>
                <input type="date" name="desativacao" id="desativacao" value="{{ $contact->desativacao }}"
                       class="input input-bordered w-full">
            </label>
        </div>
    @else
        {{-- View-Only Mode --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

            @php $readonly = 'readonly disabled'; @endphp

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Local</span></div>
                <input type="text" name="local" id="local" value="{{ $contact->local }}"
                       placeholder="Local" class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Grupo</span></div>
                <input type="text" name="grupo" id="grupo" value="{{ $contact->grupo }}"
                       placeholder="Grupo" class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Nome</span></div>
                <input type="text" name="nome" id="nome" value="{{ $contact->nome }}"
                       placeholder="Nome" class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Telemóvel</span></div>
                <input type="text" name="telemovel" id="telemovel" value="{{ $contact->telemovel }}"
                       placeholder="Telemóvel" class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Extensão</span></div>
                <input type="text" name="extensao" id="extensao" value="{{ $contact->extensao }}"
                       placeholder="Extensão" class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Funcionalidades</span></div>
                <input type="text" name="funcionalidades" id="funcionalidades" value="{{ $contact->funcionalidades }}"
                       placeholder="Funcionalidades" class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ativação/Reativação</span></div>
                <input type="date" name="ativacao" id="ativacao" value="{{ $contact->ativacao }}"
                       class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Desativação</span></div>
                <input type="date" name="desativacao" id="desativacao" value="{{ $contact->desativacao }}"
                       class="input input-bordered w-full bg-base-200" {{ $readonly }}>
            </label>
        </div>
    @endcan
</form>
