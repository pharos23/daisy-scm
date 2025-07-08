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
                @php
                    $query = request()->all();
                @endphp
                <button class="btn btn-sm btn-outline"
                        onclick="window.location='{{ route('contacts.show', ['id' => $contact->id]) }}?{{ http_build_query($query) }}'">
                    {{ __('More') }}
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
