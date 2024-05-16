<?php

namespace App\Http\Controllers;

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
        // Logika pembayaran dan penyimpanan order
        return redirect()->route('frontend.dashboard_user.index')->with('success', 'Pembayaran berhasil');
    }
}
