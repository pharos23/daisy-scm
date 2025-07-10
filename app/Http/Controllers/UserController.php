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

        // Filter soft deletes
        $deletedFilter = $request->query('deleted', 'active');

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

        // Apply soft delete filter
        switch ($deletedFilter) {
            case 'deleted':
                $query->onlyTrashed();
                break;
            case 'all':
                $query->withTrashed();
                break;
            case 'active':
            default:
                break;
        }

        $users = $query->latest('id')->paginate(8)->withQueryString();

        $translations = [
            "validation.passwords_do_not_match" => __("validation.passwords_do_not_match"),
            "validation.password_strength" => __("validation.password_strength"),
            "validation.username_required" => __("validation.username_required"),
            "validation.password_required" => __("validation.password_required"),
            "validation.name_required" => __("validation.name_required"),
            "validation.select_at_least_one_role" => __("validation.select_at_least_one_role"),
            "users.delete_confirm" => __("users.delete_confirm"),
            "validation.invalid_username" => __("validation.invalid_username"),
            "validation.invalid_name" => __("validation.invalid_name"),
            "validation.invalid_password" => __("validation.invalid_password"),
            "validation.leave_blank" => __("validation.leave_blank"),
            "validation.force_password_change" => __("validation.force_password_change"),
            "validation.force_password_change_next" => __("validation.force_password_change_next")
        ];

        return view('users.index', [
            'users' => $users,
            'roles' => Role::pluck('name')->all(),
            'translations' => $translations,
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
            ->withSuccess(__('User') . ' ' . __('deactivated successfully'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (!auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $user->restore();

        return redirect()->route('users.index')->with('success', __('User') . ' ' . __('restored successfully'));
    }
}
