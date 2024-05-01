<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::whereNull('deleted_at')->get();
        return view('backend.contacts.index', compact('contacts'));
    }

    public function formTambah()
    {
        return view('backend.contacts.formTambah');
    }

    public function prosesTambah(Request $request)
    {
        $request->validate([
            'editor' => 'required',
        ]);

        $konten = $request->editor;

        Contact::create([
            'konten' => $konten,
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);

        return view('backend.contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'konten' => 'required',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->konten = $request->input('konten');
        $contact->save();

        return redirect()->route('contact.index')->with('success', 'Kontak berhasil diupdate');
    }


    public function hapus($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->route('contact.index')->with('success', 'Kontak berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('contact.index')->with('error', 'Gagal menghapus kontak: ' . $e->getMessage());
        }
    }
}
