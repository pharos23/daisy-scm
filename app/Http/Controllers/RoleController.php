<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Controller for managing user roles using Spatie Permission.
 * Handles listing, creating, updating, and deleting roles.
 */
class RoleController extends Controller
{
    /**
     * Apply middleware for authentication and authorization on each action.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }

    /**
     * Display a paginated list of roles with their permissions.
     *
     * @return View
     */
    public function index(): View
    {
        $translations = [
            'validation.invalid_role_name' => __('validation.invalid_role_name')
        ];

        return view('roles.index', [
            'roles' => Role::with('permissions')->orderBy('id', 'DESC')->paginate(8),
            'permissions' => Permission::get(),
            'translations' => $translations
        ]);
    }

    /**
     * Show the form for creating a new role (not used).
     */
    public function create(): View
    {
        abort(404);
    }

    /**
     * Store a new role and assign selected permissions.
     *
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        // Assign permissions to role
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->withSuccess(__('Role') .' '. __('created successfully'));
    }

    /**
     * Redirects to the index. No specific role detail view implemented.
     *
     * @return RedirectResponse
     */
    public function show(): RedirectResponse
    {
        return redirect()->route('roles.index');
    }

    /**
     * Show the edit form for a role (not used).
     *
     * @param Role $role
     * @return View
     */
    public function edit(Role $role): View
    {
        abort(404);
    }

    /**
     * Update a role's name and permissions.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->back()
            ->withSuccess(__('Role') .' '. __('Updated successfully'));
    }

    /**
     * Delete a role unless it is protected (e.g. Super Admin or own role).
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        if($role->name=='Super Admin'){
            abort(403, __('SUPER ADMIN ROLE CAN NOT BE DELETED'));
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, __('CAN NOT DELETE SELF ASSIGNED ROLE'));
        }
        $role->delete();
        return redirect()->route('roles.index')
            ->withSuccess(__('Role') .' '. __('deleted successfully'));
    }
}
