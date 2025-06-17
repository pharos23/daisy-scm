<form action="{{ route('contacts.updateTicket', $contact->id) }}" method="POST" id="contact-form-ticket">
    @csrf
    @method('PUT')
    @can('edit-contact')
        <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Ticket SCMP</legend>
                    <input type="text" class="input" placeholder="Ticket SCMP"
                           name="ticket_scmp" id="ticket_scmp" value="{{ $contact->ticket_scmp }}" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Ticket FSE</legend>
                    <input type="text" class="input" placeholder="Ticket FSE"
                           name="ticket_fse" id="ticket_fse" value="{{ $contact->ticket_fse }}" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">ICCID</legend>
                    <input type="text" class="input" placeholder="ICCID"
                           name="iccid" id="iccid" value="{{ $contact->iccid }}" />
                </fieldset>
            </div>
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Equipamento</legend>
                    <input type="text" class="input" placeholder="Equipamento"
                           name="equipamento" id="equipamento" value="{{ $contact->equipamento }}" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">S/N</legend>
                    <input type="text" class="input" placeholder="Serial Number"
                           name="equip_sn" id="equip_sn" value="{{ $contact->equip_sn }}" />
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">IMEI</legend>
                    <input type="text" class="input" placeholder="IMEI"
                           name="imei" id="imei" value="{{ $contact->imei }}" />
                </fieldset>
            </div>
        </div>
        <div class="m-5 ml-10">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Obs</legend>
                <textarea class="textarea h-50 w-[80%] min-w-100" placeholder="Observações"
                          name="obs" id="obs">{{ old('obs', $contact->obs) }}</textarea>
            </fieldset>
        </div>
    @else
        <div class="md:grid md:auto-cols-2 grid-flow-col gap-4 m-5 ml-10">
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Ticket SCMP</legend>
                    <input type="text" class="input" placeholder="Ticket SCMP"
                           name="ticket_scmp" id="ticket_scmp" value="{{ $contact->ticket_scmp }}" disabled/>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Ticket FSE</legend>
                    <input type="text" class="input" placeholder="Ticket FSE"
                           name="ticket_fse" id="ticket_fse" value="{{ $contact->ticket_fse }}" disabled/>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">ICCID</legend>
                    <input type="text" class="input" placeholder="ICCID"
                           name="iccid" id="iccid" value="{{ $contact->iccid }}" disabled/>
                </fieldset>
            </div>
            <div>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Equipamento</legend>
                    <input type="text" class="input" placeholder="Equipamento"
                           name="equipamento" id="equipamento" value="{{ $contact->equipamento }}" disabled/>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">S/N</legend>
                    <input type="text" class="input" placeholder="Serial Number"
                           name="equip_sn" id="equip_sn" value="{{ $contact->equip_sn }}" disabled/>
                </fieldset>
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">IMEI</legend>
                    <input type="text" class="input" placeholder="IMEI"
                           name="imei" id="imei" value="{{ $contact->imei }}" disabled/>
                </fieldset>
            </div>
        </div>
        <div class="m-5 ml-10">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Obs</legend>
                <textarea class="textarea h-50 w-[80%] min-w-100" placeholder="Observações"
                          name="obs" id="obs" disabled>{{ old('obs', $contact->obs) }} </textarea>
            </fieldset>
        </div>
    @endcan
</form>
