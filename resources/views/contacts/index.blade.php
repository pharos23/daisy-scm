@extends('layouts.app')
<title>{{ __('Contacts') }}</title>

@section('content')
    @vite('resources/js/pages/contacts.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Table Header --}}
            @include('contacts.partials.header', ['isAdmin' => $isAdmin])

            {{-- Table --}}
            <div class="m-5">
                @include('contacts.partials.table', ['contacts' => $contacts])
            </div>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                <div class="pagination">
                    {{ $contacts->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

    {{-- New Contact Modal --}}
    @include('contacts.partials.modal_new')

    <script>
        window.translations = @json($translations);
    </script>
@endsection
