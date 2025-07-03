@extends('layouts.app')
<title>{{ __('Permissions') }}</title>
@section('content')
    @vite('resources/js/pages/permissions.js')

    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Table Heading --}}
            <div class="flex w-full justify-between">
                {{-- Search Bar --}}
                <input type="text" id="permissionSearch" placeholder="{{__("Search")}} {{__("Permissions")}}..." class="input input-bordered w-full max-w-xs m-5" />

                {{-- Button for creating a new permission --}}
                @can('create-permission')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_permission.showModal()">{{__("New")}}</button>
                @endcan

                {{-- Modal for creating a new permission --}}
                <dialog id="modal_permission" class="modal">
                    <div class="modal-box w-full max-w-xl">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <h3 class="text-2xl font-semibold mb-4">{{__("Create")}} {{__("Newa")}} {{__("Permission")}}</h3>

                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">{{__("Name")}}</span>
                                </div>
                                <input type="text" class="input input-bordered w-full" name="name" id="permission-name" placeholder="ex: edit-user" required />
                                <div class="label hidden text-error" id="permission-error-label">
                                    <span class="label-text-alt">{{__("This field is required")}}</span>
                                </div>
                            </label>

                            <div class="flex justify-end gap-2 mt-6">
                                <button class="btn btn-accent" id="permission-submit" type="submit" disabled>{{__("Create")}}</button>
                            </div>
                        </form>
                    </div>
                </dialog>
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
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ __('Delete this permission?') }}');"
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
@endsection
