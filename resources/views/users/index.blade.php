@extends('layouts.app')

{{-- Page title --}}
<title>{{ __('Users') }}</title>

@section('content')
    @vite('resources/js/pages/users.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Table Heading --}}
            <div class="flex w-full justify-between">
                {{-- Search + Role Filter --}}
                <div class="flex gap-4 m-5">
                    <input type="text" id="userSearch" placeholder="{{ __('Search') }}..." class="input input-bordered w-full max-w-xs" />

                    <select id="roleFilter" class="select select-bordered max-w-xs">
                        <option value="">{{ __('All Roles') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>

                    <select id="filterDeleted" class="select select-bordered">
                        <option value="active" {{ request('deleted') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="deleted" {{ request('deleted') == 'deleted' ? 'selected' : '' }}>{{ __('Deleted') }}</option>
                        <option value="all" {{ request('deleted') == 'all' ? 'selected' : '' }}>{{ __('All') }}</option>
                    </select>
                </div>

                {{-- New User Button --}}
                @can('create-user')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_user.showModal()">{{ __('New') }}</button>
                @endcan
            </div>

            {{-- Table --}}
            <div class="m-5">
                <table class="table table-zebra table-sm w-full" id="usersTable">
                    <thead class="bg-base-200 text-base-content">
                    <tr>
                        <th>#</th>
                        <th>{{ __("Name") }}</th>
                        <th>Username</th>
                        <th>{{ __("Roles") }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="name">{{ $user->name }}</td>
                            <td class="username">{{ $user->username }}</td>
                            <td class="roles">
                                <ul>
                                    @forelse ($user->getRoleNames() as $role)
                                        <li>
                                            <div class="badge badge-outline">{{ $role }}</div>
                                        </li>
                                    @empty
                                        <li>
                                            @if(!$user->trashed())
                                                <div class="badge badge-error text-white font-bold animate-pulse">
                                                    {{ __("No role") }}
                                                </div>
                                            @else
                                                <div class="text-gray-400 italic">
                                                    {{ __("No role") }}
                                                </div>
                                            @endif
                                        </li>
                                    @endforelse
                                </ul>
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2">
                                    @php $isSuperAdmin = in_array('Super Admin', $user->getRoleNames()->toArray()); @endphp

                                    @if ($isSuperAdmin)
                                        @if (Auth::user()->hasRole('Super Admin'))
                                            <button
                                                class="btn btn-sm btn-primary open-edit-user"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}"
                                                data-roles='@json($user->getRoleNames())'>
                                                {{ __("Edit") }}
                                            </button>
                                            <button class="btn btn-sm btn-error" disabled>{{ __("Deactivate") }}</button>
                                            @if($user->trashed())
                                                <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-info" onclick="return confirm('{{ __('Are you sure you want to restore this user?') }}')">
                                                        {{ __('Restore') }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    @else
                                        @if($user->trashed())
                                            <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="btn btn-sm btn-info" onclick="return confirm('{{ __('Are you sure you want to restore this user?') }}')">
                                                    {{ __('Restore') }}
                                                </button>
                                            </form>
                                        @endif

                                        @can('edit-user')
                                            <button
                                                class="btn btn-sm btn-primary open-edit-user"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}"
                                                data-roles='@json($user->getRoleNames())'
                                                data-force-password-change="{{ $user->force_password_change ? 'true' : 'false' }}"
                                            >
                                                {{ __("Edit") }}
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary" disabled>{{ __("Edit") }}</button>
                                        @endcan

                                        @can('delete-user')
                                            @if (Auth::user()->id !== $user->id)
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ __('Delete this user?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-error">{{ __("Deactivate") }}</button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-error" disabled>{{ __("Deactivate") }}</button>
                                            @endif
                                        @else
                                            <button class="btn btn-sm btn-error" disabled>{{ __("Deactivate") }}</button>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-error font-semibold">{{ __("No User Found!") }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                <div class="pagination">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Include Modals --}}
    @include('users.partials.create_modal')
    @include('users.partials.edit_modal')

    <script>
        window.translations = @json($translations);
    </script>

@endsection
