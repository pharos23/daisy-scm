<dialog id="modal_new" class="modal">
    <div class="modal-box w-full max-w-xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="text-2xl font-semibold mb-4">{{ __('New Contact') }}</h3>

        <form action="{{ route('contacts.create') }}" method="POST" id="contact-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Local --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __('Local') }}</span></div>
                    <select class="select select-bordered w-full" name="local" id="local" required>
                        <option disabled selected>{{ __('ChooseLocal') }}</option>
                        <option>Hospital Prelada</option>
                        <option>Spec</option>
                        <option>Conde de Ferreira</option>
                    </select>
                    <div class="label hidden text-warning text-sm" id="local-error">
                        <span class="label-text-alt">{{ __('ChooseLocal') }}</span>
                    </div>
                </label>

                {{-- Grupo --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __('Group') }}</span></div>
                    <select class="select select-bordered w-full" name="grupo" id="grupo" required>
                        <option disabled selected>{{ __('ChooseGroup') }}</option>
                        <option>DSI</option>
                        <option>OPS</option>
                        <option>Transporte</option>
                    </select>
                    <div class="label hidden text-warning text-sm" id="grupo-error">
                        <span class="label-text-alt">{{ __('ChooseGroup') }}</span>
                    </div>
                </label>

                {{-- Nome --}}
                <label class="form-control w-full">
                    <div class="label"><span class="label-text">{{ __('Name') }}</span></div>
                    <input type="text" class="input input-bordered w-full" placeholder="{{ __('Name') }}"
                           name="nome" id="nome" value="{{ old('nome') }}" required />
                    <div class="label hidden text-error text-sm" id="nome-error">
                        <span class="label-text-alt">{{ __('validation.name_required') }}</span>
                    </div>
                </label>

                {{-- Telemóvel --}}
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">{{ __('Cellphone') }}</span>
                    </div>
                    <input type="text" class="input input-bordered w-full" placeholder="{{ __('Cellphone') }}"
                           name="telemovel" id="telemovel" value="{{ old('telemovel') }}" pattern="^\d{9}$" required />
                    <div class="label hidden text-error text-sm" id="telemovel-error">
                        <span class="label-text-alt">{{ __('validation.invalid_cellphone') }}</span>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button class="btn btn-accent" id="submitBtn" type="submit" disabled>{{ __('Create') }}</button>
            </div>
        </form>
    </div>
</dialog>
