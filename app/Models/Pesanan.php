<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{

    protected $table = 'pesanan';

    protected $fillable = [
        'iduser',
        'status',
        // Tambahkan kolom lain yang diperlukan
    ];

}
