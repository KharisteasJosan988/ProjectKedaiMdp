<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pesanan extends Model
{

    protected $table = 'pesanan';

    protected $fillable = [
        'iduser',
        'status',
        // Tambahkan kolom lain yang diperlukan
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

}
