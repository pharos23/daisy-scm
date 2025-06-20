<form action="{{ route('contacts.updateTicket', $contact->id) }}" method="POST" id="contact-form-ticket">
    {{--  Blade to show the "Ticketing" tab of the selected contact --}}
    @csrf
    @method('PUT')

    @can('edit-contact')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

            {{-- Left Column --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ticket SCMP</span></div>
                <input type="text" name="ticket_scmp" id="ticket_scmp" value="{{ $contact->ticket_scmp }}"
                       placeholder="Ticket SCMP" class="input input-bordered w-full">
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ticket FSE</span></div>
                <input type="text" name="ticket_fse" id="ticket_fse" value="{{ $contact->ticket_fse }}"
                       placeholder="Ticket FSE" class="input input-bordered w-full">
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">ICCID</span></div>
                <input type="text" name="iccid" id="iccid" value="{{ $contact->iccid }}"
                       placeholder="ICCID" class="input input-bordered w-full">
            </label>

            {{-- Right Column --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">Equipamento</span></div>
                <input type="text" name="equipamento" id="equipamento" value="{{ $contact->equipamento }}"
                       placeholder="Equipamento" class="input input-bordered w-full">
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Serial Number</span></div>
                <input type="text" name="serial_number" id="serial_number" value="{{ $contact->serial_number }}"
                       placeholder="Serial Number" class="input input-bordered w-full">
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">IMEI</span></div>
                <input type="text" name="imei" id="imei" value="{{ $contact->imei }}"
                       placeholder="IMEI" class="input input-bordered w-full">
            </label>
        </div>

        {{-- OBS Section - Full Width --}}
        <div class="px-6 pb-6">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Observações</span>
                </label>
                <textarea name="obs" id="obs"
                          placeholder="Observações"
                          class="textarea textarea-bordered w-full min-h-[10rem]">{{ old('obs', $contact->obs) }}</textarea>
            </div>
        </div>

    @else
        {{-- Read-only version --}}
        @php $readonly = 'readonly disabled'; @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ticket SCMP</span></div>
                <input type="text" value="{{ $contact->ticket_scmp }}" class="input input-bordered bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Ticket FSE</span></div>
                <input type="text" value="{{ $contact->ticket_fse }}" class="input input-bordered bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">ICCID</span></div>
                <input type="text" value="{{ $contact->iccid }}" class="input input-bordered bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Equipamento</span></div>
                <input type="text" value="{{ $contact->equipamento }}" class="input input-bordered bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">Serial Number</span></div>
                <input type="text" value="{{ $contact->equip_sn }}" class="input input-bordered bg-base-200" {{ $readonly }}>
            </label>

            <label class="form-control w-full">
                <div class="label"><span class="label-text">IMEI</span></div>
                <input type="text" value="{{ $contact->imei }}" class="input input-bordered bg-base-200" {{ $readonly }}>
            </label>
        </div>

        <div class="px-6 pb-6">
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Observações</span>
                </label>
                <textarea class="textarea textarea-bordered bg-base-200 w-full min-h-[10rem]" {{ $readonly }}>{{ old('obs', $contact->obs) }}</textarea>
            </div>
        </div>
    @endcan
</form>
