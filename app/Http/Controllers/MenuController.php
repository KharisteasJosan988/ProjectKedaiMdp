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
            $menu->gambar_url = asset('storage/' . $menu->gambar);
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

        // Menyimpan gambar
        $gambarPath = $request->file('gambar')->store('menu_images');

        // Membuat record baru dalam database
        Menu::create([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('backend.menu.index')->with('success', 'Menu berhasil ditambahkan.');
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
        ]);

        // Menemukan menu yang akan diubah
        $menu = Menu::findOrFail($id);

        // Menyimpan perubahan pada menu
        $menu->update([
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return redirect()->route('backend.menu.index')->with('success', 'Menu berhasil diupdate.');
    }

    public function hapus($id)
    {
        // Menemukan menu yang akan dihapus
        $menu = Menu::findOrFail($id);

        // Menghapus gambar dari penyimpanan
        Storage::delete($menu->gambar);

        // Menghapus menu dari database
        $menu->delete();

        return redirect()->route('enu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
