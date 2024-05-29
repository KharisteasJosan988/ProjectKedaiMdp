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

        if ($pesanan !== null) {
            // // Misalnya, data ini didapatkan dari sesi atau database
            // $cartItems = session()->get('cart', []);
            // $totalPrice = array_sum(array_column($cartItems, 'price'));
            $cartItems = ItemPesanan::with('menu')->where('idpesanan', $pesanan->id)->get();
            foreach ($cartItems  as $ca) {
                $totalPrice += $ca->subtotal;
                // $totalPrice = $totalPrice + $ca->subtotal;
            }
        }

        $cart = [];
        foreach ($cartItems as $item) {
            $cart[$item->menu->id] = ['qty' => $item->qty, 'price' => $item->menu->harga];
        }
        session()->put('cart', $cart);

        return view('frontend.keranjang_user.index', compact('cartItems', 'totalPrice'));
    }

    public function tambahKeKeranjang(Request $request)
    {
        $iduser = Auth::guard('user')->user()->id;
        $pesanan = Pesanan::firstOrCreate(
            ['iduser' => $iduser, 'status' => 0],
            ['total_harga' => 0]
        );

        $menu = Menu::find($request->idmenu);
        $itemPesanan = ItemPesanan::firstOrNew(
            ['idpesanan' => $pesanan->id, 'idmenu' => $menu->id]
        );
        $itemPesanan->qty = $request->qty;
        $itemPesanan->subtotal = $menu->harga * $request->qty;
        $itemPesanan->save();

        // Update session cart
        $cart = session()->get('cart', []);
        $cart[$menu->id] = ['qty' => $request->qty, 'price' => $menu->harga];
        session()->put('cart', $cart);

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang']);
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

            // Update session cart
            $cart = session()->get('cart', []);
            unset($cart[$cartItems->idmenu]);
            session()->put('cart', $cart);

            return response()->json(['message' => 'Item pesanan berhasil dihapus', 'subtotal' => $subtotal], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus item pesanan: ' . $e->getMessage()], 500);
        }
    }
}
