<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPesanan extends Model
{
    use HasFactory;

    protected $table = 'item_pesanan';

    protected $fillable = [
        'idpesanan',
        'idmenu',
        'qty',
        'subtotal',

        // Tambahkan kolom lain yang diperlukan
    ];

    // Relasi dengan model Menu (jika diperlukan)
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu');
    }
}
