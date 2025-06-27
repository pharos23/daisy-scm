@extends('layouts.app')

@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-[90%] h-[90%] p-6 relative">

            {{-- Success flash --}}
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Dashboard Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                {{-- Total Users --}}
                <div class="stat shadow place-items-center">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value text-primary">
                        {{ \App\Models\User::count() }}
                    </div>
                    <div class="stat-desc">All-time</div>
                </div>

                {{-- Active Users This Month --}}
                <div class="stat shadow place-items-center">
                    <div class="stat-title">New Users</div>
                    <div class="stat-value text-accent">
                        {{ \App\Models\User::whereBetween('created_at', [now()->startOfMonth(), now()->endOfDay()])->count() }}
                    </div>
                    <div class="stat-desc">This Month</div>
                </div>

                {{-- Roles Count --}}
                <div class="stat shadow place-items-center">
                    <div class="stat-title">Roles Defined</div>
                    <div class="stat-value text-secondary">
                        {{ \Spatie\Permission\Models\Role::count() }}
                    </div>
                    <div class="stat-desc">Available</div>
                </div>

                {{-- Most Popular Role --}}
                <div class="stat shadow place-items-center">
                    <div class="stat-title">Most Popular Role</div>
                    <div class="stat-value">
                        {{
                            DB::table('model_has_roles')
                                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                                ->select('roles.name', DB::raw('count(*) as total'))
                                ->groupBy('roles.name')
                                ->orderByDesc('total')
                                ->first()?->name ?? 'N/A'
                        }}
                    </div>
                    <div class="stat-desc">Top assigned role</div>
                </div>
            </div>

            {{-- Recent Users --}}
            <div class="card shadow bg-base-100 overflow-x-auto">
                <div class="card-body">
                    <h2 class="card-title mb-4">Recently Added Users</h2>
                    <table class="table table-zebra w-full">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Roles</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(
                            \App\Models\User::orderBy('created_at', 'desc')->limit(5)->get()
                            as $user
                        )
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="badge badge-outline">{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Contact Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="stat shadow place-items-center">
                    <div class="stat-title">Total Contacts</div>
                    <div class="stat-value text-primary">
                        {{ DB::table('contacts')->count() }}
                    </div>
                    <div class="stat-desc">Across all users</div>
                </div>

                <div class="stat shadow place-items-center">
                    <div class="stat-title">New Contacts (Month)</div>
                    <div class="stat-value text-accent">
                        {{ DB::table('contacts')
                            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfDay()])
                            ->count()
                        }}
                    </div>
                    <div class="stat-desc">Added this month</div>
                </div>

                <div class="stat shadow place-items-center">
                    <div class="stat-title">Unique Groups</div>
                    <div class="stat-value text-secondary">
                        {{ DB::table('contacts')->distinct('grupo')->count('grupo') }}
                    </div>
                    <div class="stat-desc">Active Groups</div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex justify-end gap-4 mt-8">
                @can('create-user')
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a>
                @endcan
                @can('create-contact')
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Manage Contacts</a>
                @endcan
            </div>
        </div>
    </div>
@endsection
