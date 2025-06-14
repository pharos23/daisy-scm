@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            <!-- Button for creating a new role -->
            <div class="flex justify-end">
                @can('create-role')
                    <button class="btn btn-primary place-items-center m-5" onclick="window.location='{{ route('roles.create') }}'">Add New Role</button>
                @endcan
            </div>

            <!-- Table -->
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col" style="max-width:100px;">Role Name</th>
                    <th scope="col">Permissions</th>
                    <th scope="col" style="width: 250px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $role->name }}</td>
                        <td>
                            <ul>
                                @forelse ($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @empty
                                @endforelse
                            </ul>
                        </td>
                        <td>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                @if ($role->name!='Super Admin')
                                    @can('edit-role')
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                    @endcan

                                    @can('delete-role')
                                        @if ($role->name!=Auth::user()->hasRole($role->name))
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> Delete</button>
                                        @endif
                                    @endcan
                                @endif

                            </form>
                        </td>
                    </tr>
                @empty
                    <td colspan="3">
                    <span class="text-danger">
                        <strong>No Role Found!</strong>
                    </span>
                    </td>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="absolute bottom-0 center w-full p-5">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
