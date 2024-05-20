<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;


class UserCartController extends Controller
{
    public function index()
    {
        // Misalnya, data ini didapatkan dari sesi atau database
        $cartItems = session()->get('cart', []);
        $totalPrice = array_sum(array_column($cartItems, 'price'));

        return view('frontend.keranjang_user.index', compact('cartItems', 'totalPrice'));
    }

    public function checkout(Request $request)
    {
        // Proses checkout sesuai metode pembayaran yang dipilih
        $paymentMethod = $request->input('payment_method');

        // Simpan pesanan ke dalam database
        $cartItems = session()->get('cart', []);
        foreach ($cartItems as $item) {
            Pesanan::create([
                'menu_id' => $item['id'], // Sesuaikan dengan kolom yang sesuai di dalam tabel pesanan
                'quantity' => $item['quantity'],
                // tambahkan kolom lain yang diperlukan
            ]);
        }

        // Bersihkan keranjang setelah checkout
        session()->forget('cart');

        // Logika pembayaran dan penyimpanan order
        return redirect()->route('frontend.dashboard_user.index')->with('success', 'Pembayaran berhasil');
    }
}
