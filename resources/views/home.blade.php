@extends('layouts.app')
{{-- Home page for user. After logging in the user is redirected to this page --}}
@section('content')
    <div class="bg-base size-full flex justify-center items-center max-h-screen">

        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-200 w-200 min-w-[90%] h-250 max-h-[90%] relative">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-wrap justify-center m-5">
                <div class="stats shadow">
                    <div class="stat place-items-center">
                        <div class="stat-title">Role</div>
                        <div class="stat-value">{{ Auth::user()->getRoleNames()->first() }}</div>
                        <div class="stat-desc"> {{-- Different message depending on the role the current user has --}}
                            @if(Auth::user()->hasRole('Super Admin'))
                                Maybe important !
                            @elseif(Auth::user()->hasRole('Admin'))
                                The power of the Admin !
                            @elseif(Auth::user()->hasRole('Contact Manager'))
                                Manage and Contact !
                            @elseif(Auth::user()->hasRole('User'))
                                You are the system !
                            @endif
                        </div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title">Contacts</div>
                        <div class="stat-value">{{ DB::table('contacts')->count() }}</div>
                        <div class="stat-desc">More than last month!</div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title">New Contacts</div>
                        <div class="stat-value">{{ DB::table('contacts')
                            ->whereBetween('created_at', [
                                now()->subWeek()->startOfWeek(),
                                now()->endOfDay()])
                                ->count() }}
                        </div>
                        <div class="stat-desc">This Week!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
