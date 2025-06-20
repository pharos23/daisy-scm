<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Imports\ContactsImport;
use App\Models\Contact;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// Controller for managing contacts. Create, edit, etc.
class ContactController extends Controller
{
    // Function to paginate
    public function index($request) {
        $contacts = Contact::query()->paginate();
        $perPage = $request->input('perPage', 8);

        return view('contacts.index', compact('contacts'));
    }

    // Function to search the database
    public function search(Request $request)
    {
        $search = $request->input('search');
        $contacts = Contact::where('local', 'like', "%$search%")
            ->orWhere('grupo', 'like', "%$search%")
            ->orWhere('nome', 'like', "%$search%")
            ->orWhere('telemovel', 'like', "%$search%")
            ->paginate(8);

        return view('contacts.index', compact('contacts'));
    }

    // Function to store the data in the database when creating a new entry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'local' => ['required', 'string', 'max:20'],
            'grupo' => ['nullable', 'string', 'max:20'],
            'nome' => ['required', 'string', 'max:20'],
            'telemovel' => ['required'],
        ]);

        Contact::create($validated);

        return back()->with('success', 'Contact created successfully');
    }

    // Function to show the selected contact (dependent on the id)
    public function show($id)
    {
        $contact = Contact::find($id);
        return view('contacts.show', compact('contact'));
    }

    // Function to update the entries in the "Pessoal" tab
    public function update(Request $request, $id)
    {
        $request->validate([
            'local' => ['required', 'string', 'max:20'],
            'grupo' => ['nullable', 'string', 'max:20'],
            'nome' => ['required', 'string', 'max:20'],
            'telemovel' => ['required'],
            'extensao' => ['nullable', 'string', 'max:20'],
            'funcionalidades' => ['nullable', 'string', 'max:20'],
            'ativacao' => ['nullable', 'string', 'max:20'],
            'desativacao' => ['nullable', 'string', 'max:20'],
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());

        return redirect()->back()->with('success', 'Save successful');
    }

    // Function to update the entries in the "Ticketing" tab
    public function updateTicket(Request $request, $id)
    {
        $request->validate([
            'ticket_scmp' => ['nullable', 'string', 'max:20'],
            'ticket_fse' => ['nullable', 'string', 'max:20'],
            'iccid' => ['nullable', 'string', 'max:20'],
            'equipamento' => ['nullable', 'string', 'max:20'],
            'serial_number' => ['nullable', 'string', 'max:20'],
            'imei' => ['nullable', 'string', 'max:20'],
            'obs' => ['nullable', 'string', 'max:255'],
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());

        return redirect()->back()->with('success', 'Save successful')
            ->with('activeTab', 'ticketing');

    }

    // Function to delete an entry
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts')
            ->with('deleted','Contact deleted successfully');
    }

    public function export()
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ContactsImport, $request->file('file'));

        return back()->with('success', 'Contacts imported successfully.');
    }

}
