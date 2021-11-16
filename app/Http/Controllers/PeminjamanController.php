<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Cart;
use App\Models\Barang;
use App\Models\User;
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
        $datas = Peminjaman::orderBy("id")->get();
        foreach ($datas as $pinjam) {
            $cart = Cart::join('barangs', 'carts.id_barang', '=', 'barangs.id')->where('carts.id_peminjaman', $pinjam->id)->get();
            $pinjam->peminjam = User::where('id', $pinjam->user_id)->first();
            $pinjam->cart = $cart;
        }

        return response()->json($datas);
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
            
            $cart = Cart::create([
                "id_peminjaman" => $peminjaman->id,
                "id_barang" => $request->cart[$i]['id'],
                "kuantitas" =>  $request->cart[$i]['kuantitas']
            ]);
            $barang = Barang::where('id', $cart->id_barang)->first()->kuantitas;
            Barang::where('id', $cart->id_barang)->update(['kuantitas' => ($barang - $cart->kuantitas)]);
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
    public function update(Request $request, $id)
    {
        $updated = Peminjaman::find($id)->update([
            "user_id" => $request->input('user_id'),
            "total" => $request->input('total'),
            "barang_jaminan" => $request->input('barang_jaminan'),
            "tanggal_rental" => $request->input('tanggal_rental'),
            "rencana_pengembalian" => $request->input('rencana_pengembalian'),
            "status" => $request->input('status'),
        ]);
        return response()->json($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Peminjaman::find($id)->delete();

        return response()->json($deleted);
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

    public function getAllDate()
    {
        return Peminjaman::join('users', 'users.id', '=', 'peminjamen.user_id')->get();
    }

    public function getDate()
    {

    }
}
