@extends('layouts.app')
{{--  Blade to show both tabs of the selected contact and buttons to Save, Delete and Back --}}
@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Tabs --}}
            <div class="tabs tabs-border m-5">
                <input type="radio" name="dataTabs" class="tab" aria-label="Pessoal" checked="checked" />
                <div class="tab-content bg-base-200 p-10">
                    @include('contacts.pessoal')
                </div>

                <input type="radio" name="dataTabs" class="tab" aria-label="Ticketing" />
                <div class="tab-content bg-base-200 p-10">
                    @include('contacts.ticketing')
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 m-5 absolute bottom-5 right-5">
                @can('delete-contact')
                    <button class="btn btn-error" type="submit"
                            onclick="if(confirm('Tem a certeza que deseja apagar este contacto?')) document.getElementById('delete-form-{{ $contact->id }}').submit()">
                        {{__("Delete")}}
                    </button>

                    <form id="delete-form-{{ $contact->id }}"
                          action="{{ route('contacts.destroy', $contact) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @else
                    <button class="btn btn-error" disabled="disabled">{{__("Delete")}}</button>
                @endcan
                @can('edit-contact')
                    <button id="save-button" class="btn btn-primary" type="button">{{__("Save")}}</button>
                @else
                    <button class="btn btn-accent" disabled="disabled">Save</button>
                @endcan
                <button class="btn btn-primarcontactsy" onclick="window.location='{{ route('contacts.index') }}'">{{__("Back")}}</button>
            </div>
        </div>
    </div>

    {{-- Detetar qual a tab que está aberta para fazer o submit e guardar os dados certos
    Tab 1 aberta -> Save dos dados mostrados na tab Pessoal - Tab 2 aberta -> Save dos dados mostrados na tab Ticketing --}}
    <script>
        const saveButton = document.getElementById('save-button');
        if (saveButton) {
            saveButton.addEventListener('click', function () {
                const activeTab = document.querySelector('input[name="dataTabs"]:checked');
                if (!activeTab) return;

                let formId = null;
                switch (activeTab.getAttribute('aria-label')) {
                    case 'Pessoal':
                        formId = 'contact-form';
                        break;
                    case 'Ticketing':
                        formId = 'contact-form-ticket';
                        break;
                }

                if (formId) {
                    const form = document.getElementById(formId);
                    if (form) {
                        form.submit();
                    }
                }
            });
        }
    </script>

    {{-- Verificar qual tab deve ser aberta após o refresh --}}
    <script>
        const activeTab = @json(session('activeTab'));
        if (activeTab) {
            const tabInput = document.querySelector(`input[aria-label="${activeTab.charAt(0).toUpperCase() + activeTab.slice(1)}"]`);
            if (tabInput) {
                tabInput.checked = true;
            }
        }
    </script>
@endsection
