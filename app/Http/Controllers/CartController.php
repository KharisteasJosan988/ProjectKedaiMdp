<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('user')->orderBy('created_at', 'desc')->paginate(5);
        return view('backend.carts.index', compact('pesanan'));
    }

    public function detail($id): View
    {
        $pesanan = Pesanan::with('user')->findOrFail($id);
        $cartItems = ItemPesanan::with('menu')->where('idpesanan', $pesanan->id)->get();

        $totalPrice = 0;
        foreach ($cartItems  as $ca) {
            $totalPrice = $totalPrice + $ca->subtotal;
        }

        return view('backend.carts.detail', compact('pesanan', 'cartItems', 'totalPrice'));
    }

    public function co(Request $request): RedirectResponse
    {
        $pesanan = Pesanan::findOrFail($request->idpesanan);
        $pesanan->status = 1;

        try {
            $pesanan->save();
            return redirect()->route('cart.index')->with('success', 'Pembayaran berhasil diapprove.');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Gagal approve pembayaran.');
        }
    }

    // public function deleteDetail($id)
    // {
    //     try {
    //         $pesanan = Pesanan::findOrFail($id);
    //         $pesanan->delete();
    //         return response()->json(['message' => 'Daftar Item Pesanan berhasil dihapus'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Gagal menghapus Daftar Item Pesanan: ' . $e->getMessage()], 500);
    //     }
    // }
}
