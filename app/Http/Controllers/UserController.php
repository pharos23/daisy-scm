<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $query = User::query();

        // Apply search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Apply role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->latest('id')->paginate(8)->withQueryString();

        return view('users.index', [
            'users' => $users,
            'roles' => Role::pluck('name')->all()
        ]);
    }

    public function search(Request $request)
    {
        //
    }

    public function create(): View
    {
        abort(404);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        // If the checkbox is not present, default to true
        $input['force_password_change'] = $request->boolean('force_password_change');

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess(__('User') . ' ' . __('created successfully'));
    }


    public function show(User $user): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    public function edit(User $user): View
    {
        abort(404);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        // Convert checkbox to boolean once
        $input['force_password_change'] = $request->boolean('force_password_change');

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
            // even if password is blank, still allow forcing password change
            $input['force_password_change'] = $request->boolean('force_password_change');
        }

        $user->update($input);
        $user->syncRoles($request->roles);

        return redirect()->back()
            ->withSuccess(__('User') . ' ' . __('Updated successfully'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('Super Admin') || $user->id === auth()->id()) {
            abort(403,  __('USER DOES NOT HAVE THE RIGHT PERMISSIONS'));
        }

        $user->syncRoles([]);
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User') . ' ' . __('deleted successfully'));
    }
}
