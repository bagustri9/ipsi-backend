<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $peminjaman = Peminjaman::create([
            'user_id' => $request->user_id,
            "total" => $request->total,
            "barang_jaminan" => $request->barang_jaminan,
            "tanggal_rental" => $request->tanggal_rental,
            "rencana_pengembalian" => $request->rencana_pengembalian,
            "status" => 0,
        ]);

        for ($i = 0; $i < count($request->cart); $i++) {
            Cart::create([
                "id_peminjaman" => $peminjaman->id,
                "id_barang" => $request->cart[$i]['id'],
                "kuantitas" =>  $request->cart[$i]['kuantitas']
            ]);
        }
        return response()->json($peminjaman);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }

    public function peminjamanByUser($user_id)
    {
        $pinjams = Peminjaman::where('user_id', $user_id)->get();
        foreach ($pinjams as $pinjam) {
            $cart = Cart::join('barangs', 'carts.id_barang', '=', 'barangs.id')->where('carts.id_peminjaman', $pinjam->id)->get();
            $pinjam->cart = $cart;
        }

        return response()->json($pinjams);
    }
}
