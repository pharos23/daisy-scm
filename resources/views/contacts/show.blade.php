@extends('layouts.app')
{{--  Blade to show both tabs of the selected contact and buttons to Save, Delete and Back --}}
<title>{{ __('Contacts') }}</title>
@section('content')

    @php
        $query = request()->only(['page', 'search', 'filterLocal', 'filterGroup']);
    @endphp

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div
            class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Tabs --}}
            <div class="tabs tabs-border m-5">
                <input type="radio" name="dataTabs" class="tab" aria-label="Contacto" checked="checked"/>
                <div class="tab-content bg-base-200 p-10">
                    @include('contacts.partials.pessoal')
                </div>

                <input type="radio" name="dataTabs" class="tab" aria-label="Equipamento"/>
                <div class="tab-content bg-base-200 p-10">
                    @include('contacts.partials.ticketing')
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 m-5 absolute bottom-5 right-5">
                @if($contact->trashed() && $isAdmin)
                    <form action="{{ route('contacts.restore', ['id' => $contact->id] + request()->all()) }}" method="POST">
                        @csrf
                        <button class="btn btn-info" type="submit" onclick="return confirm('{{ __('Are you sure you want to restore this contact?') }}')">
                            {{ __('Restore') }}
                        </button>
                    </form>
                @elseif(!$contact->trashed() && Gate::allows('delete-contact'))
                    <button class="btn btn-error" type="button"
                            onclick="confirmAndSubmit('{{ route('contacts.destroy', $contact) }}')">
                        {{__("Deactivate")}}
                    </button>
                    <form id="delete-form-{{ $contact->id }}"
                          action="" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @else
                    <button class="btn btn-error" disabled="disabled">{{__("Deactivate")}}</button>
                @endif

                @can('edit-contact')
                    <button id="save-button" class="btn btn-primary" type="button">{{__("Save")}}</button>
                @else
                    <button class="btn btn-accent" disabled="disabled">{{__("Save")}}</button>
                @endcan
                <button class="btn btn-primary"
                        onclick="window.location='{{ route('contacts.index') }}?{{ http_build_query(request()->all()) }}'">
                    {{__("Back")}}
                </button>
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
                    case 'Contacto':
                        formId = 'contact-form';
                        break;
                    case 'Equipamento':
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

    <script>
        function confirmAndSubmit(deleteUrl) {
            if (confirm("{{ __('DeactivateIf') }}")) {
                const form = document.getElementById('delete-form-{{ $contact->id }}');
                const url = new URL(deleteUrl);
                const params = new URLSearchParams(window.location.search);

                // Append all current query params to the delete URL
                params.forEach((value, key) => {
                    url.searchParams.set(key, value);
                });

                form.setAttribute('action', url.toString());
                form.submit();
            }
        }
    </script>
@endsection
