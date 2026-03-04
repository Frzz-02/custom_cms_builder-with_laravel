<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('backend.contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'contact_1' => 'nullable|string|max:255',
            'contact_2' => 'nullable|string|max:255',
            'contact_3' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'background' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Contact::create($validated);

        return redirect()->route('backend.contacts.index')
            ->with('success', 'Contact created successfully!');
    }

    public function edit(Contact $contact)
    {
        return view('backend.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'contact_1' => 'nullable|string|max:255',
            'contact_2' => 'nullable|string|max:255',
            'contact_3' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'background' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $contact->update($validated);

        return redirect()->route('backend.contacts.index')
            ->with('success', 'Contact updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('backend.contacts.index')
            ->with('success', 'Contact deleted successfully!');
    }
}
