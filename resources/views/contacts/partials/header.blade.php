<header class="flex flex-nowrap justify-between gap-4 m-5">
    {{-- Search and filter inputs --}}
    <div class="flex gap-4">
        <input type="text" id="searchInput" placeholder="{{ __('Search') }}..." class="input input-bordered" value="{{ request('search') }}" />

        <select id="filterLocal" class="select select-bordered">
            <option value="">{{ __('AllLocals') }}</option>
            <option value="Hospital Prelada" {{ request('local') == 'Hospital Prelada' ? 'selected' : '' }}>Hospital Prelada</option>
            <option value="Spec" {{ request('local') == 'Spec' ? 'selected' : '' }}>Spec</option>
            <option value="Conde de Ferreira" {{ request('local') == 'Conde de Ferreira' ? 'selected' : '' }}>Conde de Ferreira</option>
        </select>

        <select id="filterGroup" class="select select-bordered">
            <option value="">{{ __('AllGroups') }}</option>
            <option value="DSI" {{ request('group') == 'DSI' ? 'selected' : '' }}>DSI</option>
            <option value="OPS" {{ request('group') == 'OPS' ? 'selected' : '' }}>OPS</option>
            <option value="Transporte" {{ request('group') == 'Transporte' ? 'selected' : '' }}>Transporte</option>
        </select>

        @if ($isAdmin)
            <select id="filterDeleted" class="select select-bordered">
                <option value="active" {{ request('deleted') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="deleted" {{ request('deleted') == 'deleted' ? 'selected' : '' }}>{{ __('Deleted') }}</option>
                <option value="all" {{ request('deleted') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
            </select>
        @endif
    </div>

    {{-- Buttons --}}
    <div class="flex gap-4 ml-4">
        <form id="import-form" action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data" class="hidden">
            @csrf
            <input type="file" id="import-file" name="file" accept=".xlsx,.csv" required />
        </form>

        <button class="btn btn-success" id="trigger-import">
            {{ __('Import') }}
        </button>

        <button class="btn btn-success" onclick="window.location.href='{{ route('contacts.export') }}'">
            {{ __('Export') }}
        </button>

        @can('create-contact')
            <button class="btn btn-primary" onclick="modal_new.showModal()">{{ __('New') }}</button>
        @else
            <button class="btn btn-primary" disabled>{{ __('New') }}</button>
        @endcan
    </div>
</header>
