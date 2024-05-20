<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        foreach ($menus as $menu) {
            $menu->gambar_url = asset('menu_images/' . $menu->gambar);
        }

        return view('backend.menus.index', compact('menus'));
    }

    public function formTambah()
    {
        return view('backend.menus.formTambah');
    }

    public function prosesTambah(Request $request)
    {
        // Validasi data
        $request->validate([
            'jenis' => 'required',
            'nama' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'harga' => [
                'required',
                'regex:/^[0-9]+$/', // Hanya angka
            ],
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Batasan ukuran gambar: 2MB
        ], [
            'nama.regex' => 'Nama menu hanya boleh berisi huruf dan spasi.',
            'harga.regex' => 'Harga menu hanya boleh berisi angka.',
        ]);

        $gambar = $request->file('gambar');
        $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('menu_images'), $nama_gambar);

        // Menyimpan gambar
        $gambarPath = 'menu_images/' . $nama_gambar;

        // Membuat record baru dalam database
        Menu::create([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function formUbah($id)
    {
        $menu = Menu::findOrFail($id);
        return view('backend.menus.formUbah', compact('menu'));
    }

    // Menyimpan perubahan pada menu yang diubah ke database
    public function prosesUbah(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'jenis' => 'required',
            'nama' => [
                'required',
                'regex:/^[a-zA-Z\s]+$/', //hanya huruf
            ],
            'harga' => [
                'required',
                'regex:/^[0-9]+$/', // Hanya angka
            ],
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Batasan ukuran gambar: 2MB
        ], [
            'nama.regex' => 'Nama menu hanya boleh terdiri dari huruf dan spasi.',
            'harga.regex' => 'Harga menu hanya boleh terdiri dari angka.',
        ]);

        // Menemukan menu yang akan diubah
        $menu = Menu::findOrFail($id);

        $gambar = $request->file('gambar');
        $nama_gambar = time() . '_' . $gambar->getClientOriginalName();
        $gambar->move(public_path('menu_images'), $nama_gambar);

        // Menyimpan gambar
        $gambarPath = 'menu_images/' . $nama_gambar;

        // Menyimpan perubahan pada menu
        $menu->update([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diupdate.');
    }

    public function hapus($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete();

            return response()->json(['success' => 'Menu berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus menu.'], 500);
        }
    }
}
