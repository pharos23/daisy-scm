<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Optional: middleware for permissions
        $this->middleware('can:create-permission')->only(['store']);
        $this->middleware('can:delete-permission')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 8);
        $search = $request->input('search');

        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $permissions = $query->orderBy('name')->paginate($perPage)->withQueryString();

        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
        ]);

        \Spatie\Permission\Models\Permission::create(['name' => $validated['name']]);

        return redirect()->route('permissions.index')->with('success', __('Permission') .' '. __('createda successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission->name === 'Super Admin') {
            return redirect()->back()->withErrors('Cannot delete core permission.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', __('Permission').' '. __('deleteda successfully'));
    }
}
