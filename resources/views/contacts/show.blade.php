@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        @if($errors->any())
            <div class="mt-4">
                @foreach($errors->all() as $error)
                    <div class="bg-red-100 text-red-700 p-4 rounded">{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">
            <div class="tabs tabs-border">
                <input type="radio" name="dataTabs" class="tab" aria-label="Pessoal" checked="checked" />
                <div class="tab-content bg-base-200 p-10">
                    @include('contacts.pessoal')
                </div>

                <input type="radio" name="dataTabs" class="tab" aria-label="Ticketing" />
                <div class="tab-content bg-base-200 p-10">
                    @include('contacts.ticketing')
                </div>
            </div>
            <div class="flex gap-4 m-5 absolute bottom-5 right-5">
                @can('delete-contact')
                    <button class="btn btn-error" type="submit"
                            onclick="if(confirm('Tem a certeza que deseja apagar este contacto?')) document.getElementById('delete-form-{{ $contact->id }}').submit()"
                    >Delete
                    </button>

                    <form id="delete-form-{{ $contact->id }}"
                          action="{{ route('contacts.destroy', $contact) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @else
                    <button class="btn btn-error" disabled="disabled">Delete</button>
                @endcan
                @can('edit-contact')
                    <button class="btn btn-accent" type="submit" form="contact-form">Save</button>
                @else
                    <button class="btn btn-accent" disabled="disabled">Save</button>
                @endcan
                <button class="btn btn-primary" onclick="window.location='{{ route('contacts') }}'">Back</button>
            </div>
        </div>

        <div class="toast toast-top toast-end">
            @if(session('success'))
                <div class="alert alert-success" id="success-message">
                    <span>Save successful.</span>
                </div>
            @endif
        </div>
    </div>

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
