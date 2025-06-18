@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">

            {{-- Cabeçalho da Tabela --}}
            <div class="flex w-full justify-between">
                {{-- Search Bar --}}
                <input type="text" id="permissionSearch" placeholder="Search permission..." class="input input-bordered w-full max-w-xs m-5" />

                {{-- Button for creating a new permission --}}
                @can('create-permission')
                    <button class="btn btn-primary place-items-center m-5" onclick="modal_permission.showModal()">New</button>
                @endcan

                {{-- Modal for creating a new permission --}}
                <dialog id="modal_permission" class="modal">
                    <div class="modal-box w-full max-w-xl">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <h3 class="text-2xl font-semibold mb-4">Create New Permission</h3>

                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf

                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Permission Name</span>
                                </div>
                                <input type="text" class="input input-bordered w-full" name="name" id="permission-name" placeholder="e.g., edit-user" required />
                                <div class="label hidden text-error" id="permission-error-label">
                                    <span class="label-text-alt">This field is required.</span>
                                </div>
                            </label>

                            <div class="flex justify-end gap-2 mt-6">
                                <button class="btn btn-accent" id="permission-submit" type="submit" disabled>Create</button>
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
                    <th>Name</th>
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
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Delete this permission?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">No permissions found.</td></tr>
                @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="absolute bottom-0 center w-full p-5">
                {{ $permissions->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>

    {{--Search Function --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById('permissionSearch');
            const rows = document.querySelectorAll('#permissionsTable tbody tr');

            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const permissionName = row.querySelector('.permission-name')?.textContent.toLowerCase() ?? '';
                    const matches = permissionName.includes(query);
                    row.style.display = matches ? '' : 'none';
                });
            });
        });
    </script>

    {{-- Paginação dinamica --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const perPageSelect = document.getElementById('perPageSelect');
            const wrapper = document.getElementById('permissionsTableWrapper');

            function fetchPermissions(page = 1) {
                const search = searchInput.value;
                const perPage = perPageSelect.value;

                fetch(`{{ route('permissions.index') }}?search=${search}&perPage=${perPage}&page=${page}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(data => {
                        wrapper.innerHTML = data.html;

                        // Re-bind pagination links
                        wrapper.querySelectorAll('.pagination a').forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const url = new URL(link.href);
                                fetchPermissions(url.searchParams.get('page'));
                            });
                        });
                    });
            }

            // Bind inputs
            searchInput.addEventListener('input', () => fetchPermissions());
            perPageSelect.addEventListener('change', () => fetchPermissions());

            // Initial bind of pagination
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    fetchPermissions(url.searchParams.get('page'));
                });
            });
        });
    </script>


    {{-- JavaScript Validation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('permission-name');
            const errorLabel = document.getElementById('permission-error-label');
            const submitBtn = document.getElementById('permission-submit');

            function validatePermissionName() {
                const isValid = nameInput.value.trim().length > 0;
                errorLabel.classList.toggle('hidden', isValid);
                nameInput.classList.toggle('input-error', !isValid);
                submitBtn.disabled = !isValid;
            }

            nameInput.addEventListener('input', validatePermissionName);
            validatePermissionName();
        });
    </script>
@endsection
