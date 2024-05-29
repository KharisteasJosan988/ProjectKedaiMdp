<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\ItemPesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class UserCartController extends Controller
{
    public function index()
    {
        $iduser = Auth::guard('user')->user()->id;
        $pesanan = Pesanan::where('iduser', $iduser)->where('status', '=', 0)->first();

        $totalPrice = 0;
        $cartItems = [];

        if($pesanan !== null){
            // // Misalnya, data ini didapatkan dari sesi atau database
            // $cartItems = session()->get('cart', []);
            // $totalPrice = array_sum(array_column($cartItems, 'price'));
            $cartItems = ItemPesanan::with('menu')->where('idpesanan', $pesanan->id)->get();
            foreach ($cartItems  as $ca) {
                $totalPrice = $totalPrice + $ca->subtotal;
            }
        }

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

    public function deleteItem($id)
    {
        try {
            $cartItems = ItemPesanan::findOrFail($id);
            $subtotal = $cartItems->subtotal;
            $cartItems->delete();
            return response()->json(['message' => 'Item pesanan berhasil dihapus', 'subtotal' => $subtotal], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus item pesanan: ' . $e->getMessage()], 500);
        }
    }
}
