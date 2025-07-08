@extends('layouts.app')
<title>{{ __('Permissions') }}</title>
@section('content')
    @vite('resources/js/pages/permissions.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Table Heading --}}
            <div class="flex w-full justify-between">
                {{-- Search Bar --}}
                <input type="text" id="permissionSearch" placeholder="{{ __("Search") }}..." class="input input-bordered w-full max-w-xs m-5" />

                {{-- Button for creating a new permission --}}
                @can('create-permission')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_permission.showModal()">{{__("New")}}</button>
                @endcan
            </div>

            {{-- Table --}}
            <table class="table table-zebra w-full mt-4" id="permissionsTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__("Name")}}</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td class="permission-name">{{ $permission->name }}</td>
                        <td class="text-right">
                            @can('delete-permission')
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ __('permissions.delete_confirm') }}');"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error">{{__("Delete")}}</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">{{__("No permissions found")}}</td></tr>
                @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                <div class="pagination">
                    {{ $permissions->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('permissions.partials.permission-create')

    <script>
        window.translations = @json($translations);
    </script>
@endsection
