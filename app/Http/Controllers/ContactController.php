<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Imports\ContactsImport;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller for managing contacts.
 * Handles creation, editing, viewing, deleting, filtering, exporting, and importing.
 */
class ContactController extends Controller
{
    /**
     * Displays a paginated list of contacts with optional search, filters, and soft-delete visibility.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Determine if user wants to filter by deleted/active/all
        $deletedFilter = $request->query('deleted', 'active');

        // Apply search filter (partial match on name, phone, location, group)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome', 'like', '%' . $searchTerm . '%')
                    ->orWhere('telemovel', 'like', '%' . $searchTerm . '%')
                    ->orWhere('local', 'like', '%' . $searchTerm . '%')
                    ->orWhere('grupo', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply filter by location
        if ($request->filled('local')) {
            $query->where('local', $request->local);
        }

        // Apply filter by group
        if ($request->filled('group')) {
            $query->where('grupo', $request->group);
        }

        // If the user has Admin/Super Admin role, allow soft-delete filtering
        if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin')) {
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
        }

        // Paginate results, preserving query string filters
        $contacts = $query->paginate(8)->withQueryString();

        // Check if the user is an admin
        $isAdmin = Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin');

        // Optional: pass translations to frontend for use in JS
        $translations = [
            "validation.name_required" => __('validation.name_required'),
            "validation.invalid_cellphone" => __('validation.invalid_cellphone')
        ];

        return view('contacts.index', compact('contacts', 'isAdmin', 'translations'));
    }

    /**
     * Placeholder for a database search method (currently unused).
     */
    public function search(Request $request)
    {
        // Not implemented
    }

    /**
     * Stores a new contact in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'local' => ['required', 'string'],
            'grupo' => ['nullable', 'string'],
            'nome' => ['required', 'string', 'max:30'],
            'telemovel' => ['required'],
        ]);

        Contact::create($validated);

        return back()->with('success', __('Contact') . ' ' . __('created successfully'));
    }

    /**
     * Shows a specific contact’s details.
     */
    public function show($id)
    {
        $contact = Contact::withTrashed()->find($id);

        if (!$contact) {
            abort(404); // Optional: show 404 if not found at all
        }

        // If the contact is soft deleted, only allow Admins or Super Admins to view
        if ($contact->trashed() && !auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $isAdmin = auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin');

        return view('contacts.show', compact('contact', 'isAdmin'));
    }

    /**
     * Updates contact info in "Pessoal" tab.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'local' => ['required', 'string'],
            'grupo' => ['nullable', 'string'],
            'nome' => ['required', 'string', 'max:30'],
            'telemovel' => ['required'],
            'extensao' => ['nullable', 'string', 'max:20'],
            'funcionalidades' => ['nullable', 'string', 'max:50'],
            'ativacao' => ['nullable', 'string', 'max:20'],
            'desativacao' => ['nullable', 'string', 'max:20'],
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());

        return redirect()->back()->with('success', __('Save successful'));
    }

    /**
     * Updates fields in the "Equipment" tab.
     */
    public function updateTicket(Request $request, $id)
    {
        $request->validate([
            'ticket_scmp' => ['nullable', 'string', 'max:20'],
            'ticket_fse' => ['nullable', 'string', 'max:20'],
            'iccid' => ['nullable', 'string', 'max:22'],
            'equipamento' => ['nullable', 'string', 'max:25'],
            'serial_number' => ['nullable', 'string', 'max:20'],
            'imei' => ['nullable', 'string', 'max:15'],
            'obs' => ['nullable', 'string', 'max:255'],
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());

        return redirect()->back()->with('success', __('Save successful'))
            ->with('activeTab', 'equipamento'); // Keep "Equipment" tab active in UI

    }

    /**
     * Soft-deletes a contact.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        // Get current query params
        $queryParams = request()->query();

        // Redirect back to same contact with filters preserved
        return redirect()->route('contacts.index', ['id' => $contact->id] + $queryParams)
            ->with('deleted', __('Contact') . ' ' . __('deactivated successfully'));
    }

    public function restore($id)
    {
        $contact = Contact::onlyTrashed()->findOrFail($id);

        if (!auth()->user()->can('restore-contact')) {
            abort(403);
        }

        $contact->restore();

        // Get current query params
        $queryParams = request()->query();

        // Redirect back to same contact with filters preserved
        return redirect()->route('contacts.show', ['id' => $contact->id] + $queryParams)
            ->with('success', __('Contact') . ' ' . __('restored successfully'));
    }

    /**
     * Exports all contact data as an Excel file.
     */
    public function export()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }

    /**
     * Imports contacts from an uploaded Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return back()->withErrors(['file' => __('Invalid or missing file.')]);
        }

        try {
            // Save the uploaded file to storage/app/imports/
            $filename = 'contacts_import_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('imports', $filename);

            // Use the full path for import
            Excel::import(new ContactsImport, storage_path('app/' . $path));

            // Optional: delete the file after import
            Storage::delete($path);

            return back()->with('success', __('Contacts') . ' ' . __('imported successfully.'));
        } catch (\Throwable $e) {
            return back()->withErrors([
                'file' => __('Import failed: ') . $e->getMessage(),
            ]);
        }
    }
}
