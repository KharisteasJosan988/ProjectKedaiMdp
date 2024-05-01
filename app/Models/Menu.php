<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'nama',
        'harga',
        'gambar',
        'action',
    ];

    public function getGambarUrlAttribute()
    {
        // Pastikan properti gambar tidak kosong
        if ($this->gambar) {
            // Mengembalikan URL gambar dengan menggunakan asset()
            return asset(Storage::url($this->gambar));
        }

        // Jika tidak ada gambar, kembalikan null atau URL placeholder gambar default
        return null;
    }
}
