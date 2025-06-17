<form action="{{ route('contacts.update', $contact->id) }}" method="POST" id="contact-form">
    @csrf
    @method('PUT')
    <div class="flex-row">
        @can('edit-contact')
            <div class="flex gap-10 ml-10 mb-10">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Local</legend>
                    <input type="text" class="input" placeholder="Local"
                           name="local" id="local" value="{{ $contact->local }}" required />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Grupo</legend>
                    <input type="text" class="input" placeholder="Grupo"
                           name="grupo" id="grupo" value="{{ $contact->grupo }}" />
                </fieldset>
            </div>
            <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
                <div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Nome</legend>
                        <input type="text" class="input" placeholder="Nome"
                               name="nome" id="nome" value="{{ $contact->nome }}" required />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Telemóvel</legend>
                        <input type="text" class="input" placeholder="Telemóvel"
                               name="telemovel" id="telemovel" value="{{ $contact->telemovel }}" required />
                    </fieldset>

                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Extensão</legend>
                        <input type="text" class="input" placeholder="Extensão"
                               name="extensao" id="extensao" value="{{ $contact->extensao }}" />
                    </fieldset>
                </div>
                <div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Funcionalidades</legend>
                        <input type="text" class="input" placeholder="Funcionalidades"
                               name="funcionalidades" id="funcionalidades" value="{{ $contact->funcionalidades }}" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Ativação/Reativação</legend>
                        <input type="date" class="input" placeholder="Ativação/Reativação"
                               name="ativacao" id="ativacao" value="{{ $contact->ativacao }}" />
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Desativação</legend>
                        <input type="date" class="input" placeholder="Desativação"
                               name="desativacao" id="desativacao" value="{{ $contact->desativacao }}" />
                    </fieldset>
                </div>
            </div>
        @else
            <div class="flex gap-10 ml-10 mb-10">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Local</legend>
                    <input type="text" class="input" placeholder="Local"
                           name="local" id="local" value="{{ $contact->local }}" required disabled/>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Grupo</legend>
                    <input type="text" class="input" placeholder="Grupo"
                           name="grupo" id="grupo" value="{{ $contact->grupo }}" disabled/>
                </fieldset>
            </div>
            <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
                <div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Nome</legend>
                        <input type="text" class="input" placeholder="Nome"
                               name="nome" id="nome" value="{{ $contact->nome }}" required disabled/>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Telemóvel</legend>
                        <input type="text" class="input" placeholder="Telemóvel"
                               name="telemovel" id="telemovel" value="{{ $contact->telemovel }}" required disabled/>
                    </fieldset>

                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Extensão</legend>
                        <input type="text" class="input" placeholder="Extensão"
                               name="extensao" id="extensao" value="{{ $contact->extensao }}" disabled/>
                    </fieldset>
                </div>
                <div>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Funcionalidades</legend>
                        <input type="text" class="input" placeholder="Funcionalidades"
                               name="funcionalidades" id="funcionalidades" value="{{ $contact->funcionalidades }}" disabled/>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Ativação/Reativação</legend>
                        <input type="date" class="input" placeholder="Ativação/Reativação"
                               name="ativacao" id="ativacao" value="{{ $contact->ativacao }}" disabled/>
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Desativação</legend>
                        <input type="date" class="input" placeholder="Desativação"
                               name="desativacao" id="desativacao" value="{{ $contact->desativacao }}" disabled/>
                    </fieldset>
                </div>
            </div>
        @endcan
    </div>
</form>
