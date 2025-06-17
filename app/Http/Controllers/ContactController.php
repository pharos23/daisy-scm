<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index($request) {
        $contacts = Contact::query()->paginate();
        $perPage = $request->input('perPage', 8);

        return view('contacts.index', compact('contacts'));
    }

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'local' => ['required', 'string', 'max:20'],
            'grupo' => ['nullable', 'string', 'max:20'],
            'nome' => ['required', 'string', 'max:20'],
            'telemovel' => ['required'],
        ]);

        Contact::create($validated);

        return redirect()->route('contacts')
            ->with('success', 'Contact created successfully');
    }

    public function show($id)
    {
        $contact = Contact::find($id);
        return view('contacts.show', compact('contact'));
    }

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

    public function updateTicket(Request $request, $id)
    {
        $request->validate([
            'ticket_scmp' => ['nullable', 'string', 'max:20'],
            'ticket_fse' => ['nullable', 'string', 'max:20'],
            'iccid' => ['nullable', 'string', 'max:20'],
            'equipamento' => ['nullable', 'string', 'max:20'],
            'equip_sn' => ['nullable', 'string', 'max:20'],
            'imei' => ['nullable', 'string', 'max:20'],
            'obs' => ['nullable', 'string', 'max:255'],
        ]);

        $contact = Contact::find($id);
        $contact->update($request->all());

        return redirect()->back()->with('success', 'Save successful')
            ->with('activeTab', 'ticketing');

    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts')
            ->with('deleted','Contact deleted successfully');
    }
}
