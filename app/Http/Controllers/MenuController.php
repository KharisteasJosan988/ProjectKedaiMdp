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
            'nama' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Batasan ukuran gambar: 2MB
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
            'nama' => 'required',
            'harga' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            return response()->json(['message' => 'Menu berhasil dihapus'], 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus menu: ' . $e->getMessage()], 500);
        }
    }
}
