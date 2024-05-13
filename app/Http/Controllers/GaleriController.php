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
        // Tampilkan form untuk menambah galeri
        return view('backend.galeris.formTambah');
    }

    public function prosesTambahGaleri(Request $request)
    {
        // Simpan data galeri yang baru ditambahkan
        // Validasi data yang dikirimkan dari form tambah galeri
        $request->validate([
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Proses penyimpanan data galeri baru
        $galeri = new Galeri();
        $galeri->deskripsi = $request->deskripsi;

        // Upload gambar
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
        // Tampilkan form untuk mengedit galeri dengan id tertentu
        $galeri = Galeri::findOrFail($id);
        return view('backend.galeris.formUbah', compact('galeri'));
    }

    public function prosesUbahGaleri(Request $request, $id)
    {
        // Update data galeri dengan id tertentu
        // Validasi data yang dikirimkan dari form ubah galeri
        $request->validate([
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Proses pembaruan data galeri
        $galeri = Galeri::findOrFail($id);
        $galeri->deskripsi = $request->deskripsi;

        // Upload gambar jika ada perubahan
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
        // Hapus galeri dengan id tertentu
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
