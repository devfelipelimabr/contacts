<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    private function validate(Request $request, $id)
    {
        return $request->validate([
            'name' => 'required|string|min:6|max:128',
            'phone' => [
                'required',
                'regex:/^\d{9}$/', // Aceita exatamente 9 dígitos
                'unique:contacts,phone,NULL,id,user_id,' . $id, // Verifica unicidade do telefone para o mesmo user_id
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:contacts,email,NULL,id,user_id,' . $id, // Verifica unicidade do e-mail para o mesmo user_id
            ],
        ]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::where('user_id', Auth::id())->get();

            return DataTables::of($contacts)
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="' . route('contacts.edit', $row->id) . '" class="btn btn-warning btn-sm edit-btn" data-id="' . $row->id . '">Editar</a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('contacts.index');
    }

    public function show(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('contacts.edit', compact('contact'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, Auth::id());
        $validated['user_id'] = Auth::id();

        Contact::create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function update(Request $request, Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $this->validate($request, Auth::id());

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully.']);
    }
}
