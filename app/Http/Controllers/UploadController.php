<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function form()
    {
        return view('upload');
    }

    public function proses(Request $request)
    {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|file|max:2048', // Maksimum 2MB
        ]);

        // Simpan file ke penyimpanan
        $path = $request->file('file')->store('public/uploads');

        // Ambil URL dari penyimpanan
        $url = Storage::url($path);

        // Kembalikan respons
        return "File berhasil diunggah. URL: $url";
    }
}
