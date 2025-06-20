<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Method to show all contacts, with search and filters applied
    public function index(Request $request)
    {
        // Start the query for the contacts
        $query = Contact::query();

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome', 'like', '%' . $searchTerm . '%')
                    ->orWhere('telemovel', 'like', '%' . $searchTerm . '%')
                    ->orWhere('local', 'like', '%' . $searchTerm . '%')
                    ->orWhere('grupo', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply local filter
        if ($request->has('local') && $request->local != '') {
            $query->where('local', $request->local);
        }

        // Apply group filter
        if ($request->has('group') && $request->group != '') {
            $query->where('grupo', $request->group);
        }

        // Get paginated results
        $contacts = $query->paginate(8);

        // If the request is an AJAX request, return only the table body and pagination
        if ($request->ajax()) {
            return response()->json([
                'table' => view('contacts.partials.table', compact('contacts'))->render(),
                'pagination' => view('contacts.partials.pagination', compact('contacts'))->render(),
            ]);
        }

        // Otherwise, return the full view
        return view('contacts.index', compact('contacts'));
    }

    // Add other methods for CRUD actions here (e.g., show, store, update, destroy)
}
