<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\ItemPesanan;

class PesananController extends Controller
{
    public function chart(Request $request) : JsonResponse {
        $iduser = Auth::guard('user')->user()->id;
        $idmenu = $request->idmenu;
        $qty = $request->qty;

        $menu = Menu::findOrFail($idmenu);
        $harga = $menu->harga;
        $subtotal = $qty * $harga;

        #check pesanan yg beleum di proses
        #jika ada berarti tambahkan item pesanan di pesanan tersebut
        $check = Pesanan::where('iduser',$iduser)->where('status','=',0)->first();
        if ($check === null) {
            $pesanan = new Pesanan();
            $pesanan->iduser = $iduser;
            $pesanan->save();
            $idPesanan = $pesanan->id;
        }else{
            $idPesanan =  $check->id;
        }

        $itemPesanan = new ItemPesanan();
        $itemPesanan->idpesanan = $idPesanan;
        $itemPesanan->idmenu = $idmenu;
        $itemPesanan->qty = $qty;
        $itemPesanan->subtotal = $subtotal;
        $itemPesanan->save();

        return response()->json(['message' => 'Pesanan Saved'], 200);
    }
}
