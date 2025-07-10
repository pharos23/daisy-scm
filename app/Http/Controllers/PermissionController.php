<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

/**
 * Controller for managing permissions using Spatie's permission package.
 * Handles listing, creating, and deleting permissions.
 */
class PermissionController extends Controller
{
    /**
     * Apply middleware to restrict access to authenticated users,
     * and further restrict permission creation and deletion actions.
     */
    public function __construct()
    {
        $this->middleware('auth');

        // Optional: middleware for permissions
        $this->middleware('can:create-permission')->only(['store']);
        $this->middleware('can:delete-permission')->only(['destroy']);
    }

    /**
     * Display a list of permissions, with optional search and pagination.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 8);
        $search = $request->input('search');

        $query = Permission::query();

        // Apply search filter if provided
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Get paginated and alphabetically sorted permissions
        $permissions = $query->orderBy('name')->paginate($perPage)->withQueryString();

        // Provide translations for frontend validation
        $translations = [
            "validation.invalid_permission_name" => __("validation.invalid_permission_name"),
        ];

        return view('permissions.index', compact('permissions', 'translations'));
    }

    /**
     * Disable the "create" form route by forcing a 404.
     * Creating is handled directly via modal.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Handle creation of a new permission.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
        ]);

        // Create the permission using Spatie's model
        Permission::create(['name' => $validated['name']]);

        return redirect()->route('permissions.index')->with('success', __('Permission') .' '. __('createda successfully'));
    }

    /**
     * Show a single permission (not implemented).
     */
    public function show(string $id)
    {
        // No implementation
    }

    /**
     * Disable the "edit" form route by forcing a 404.
     * Editing is not supported in this version.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update an existing permission (not implemented).
     */
    public function update(Request $request, string $id)
    {
        // No implementation
    }

    /**
     * Delete a permission by its ID.
     * Protects core permissions like "Super Admin" from being deleted.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);

        // Prevent deleting critical/system-level permission
        if ($permission->name === 'Super Admin') {
            return redirect()->back()->withErrors('Cannot delete core permission.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', __('Permission').' '. __('deleteda successfully'));
    }
}
