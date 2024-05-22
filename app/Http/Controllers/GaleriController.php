<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::all();
        return view('backend.galeris.index', compact('galeri'));
    }

    public function formTambahGaleri()
    {
        return view('backend.galeris.formTambah');
    }

    public function prosesTambahGaleri(Request $request)
    {
        $request->validate([
            'deskripsi' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'deskripsi.regex' => 'Deskripsi hanya bisa diisi dengan huruf',
        ]);

        $galeri = new Galeri();
        $galeri->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images'), $nama_gambar);
            $galeri->gambar = '/images/' . $nama_gambar;
        }

        $galeri->save();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function ubahGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('backend.galeris.formUbah', compact('galeri'));
    }

    public function prosesUbahGaleri(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'deskripsi.regex' => 'Deskripsi hanya bisa diisi dengan huruf',
        ]);

        $galeri = Galeri::findOrFail($id);
        $galeri->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images'), $nama_gambar);
            $galeri->gambar = '/images/' . $nama_gambar;
        }

        $galeri->save();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function hapus($id)
    {
        try {
            $galeri = Galeri::findOrFail($id);
            $galeri->delete();
            return response()->json(['message' => 'Galeri berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus galeri'], 500);
        }
    }
}
