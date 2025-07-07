@extends('layouts.app')

@section('title', __('Roles'))

@section('content')
    @vite('resources/js/pages/roles.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Button for creating a new role --}}
            <div class="flex justify-end m-5">
                @can('create-role')
                    <button class="btn btn-primary" onclick="modal_role.showModal()">{{ __('New') }}</button>
                @endcan
            </div>

            {{-- Roles Table --}}
            <div class="m-5">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="max-width:100px;">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Permissions') }}</th>
                        <th scope="col" style="width: 250px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                <ul class="p-2 flex flex-wrap gap-2">
                                    @forelse ($role->permissions as $permission)
                                        <div class="badge badge-outline">{{ $permission->name }}</div>
                                    @empty
                                        <span class="text-gray-500">{{ __('No permissions') }}</span>
                                    @endforelse
                                </ul>
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <div class="flex justify-end gap-2">
                                    @if ($role->name !== 'Super Admin')
                                        @can('edit-role')
                                            <button class="btn btn-primary btn-sm open-edit-role"
                                                    data-id="{{ $role->id }}"
                                                    data-name="{{ $role->name }}"
                                                    data-permissions='@json($role->permissions->pluck('id'))'>
                                                {{ __('Edit') }}
                                            </button>
                                        @endcan

                                        @can('delete-role')
                                            @if (!Auth::user()->hasRole($role->name))
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                      onsubmit="return confirm('{{ __('Delete this role?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-error btn-sm">{{ __('Delete') }}</button>
                                                </form>
                                            @endif
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500">
                                {{ __('No roles found') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    {{-- Include Modals --}}
    @include('roles.partials.modal-create')
    @include('roles.partials.modal-edit')

    <script>
        window.translations = @json($translations);
    </script>
@endsection
