<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Pengembalian::orderBy("id")->get();

        foreach ($datas as $pinjam) {
            $pinjam->barang = Peminjaman::where('id', $pinjam->peminjaman_id)->first();
            $pinjam->info = User::where('id', $pinjam->barang->user_id)->first();
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
     * Store a newly created resource in storag e.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            "pengembalian" => $request->pengembalian,
            "denda" => $request->denda,
        ]);

        $peminjaman = Peminjaman::findOrFail(($request->peminjaman_id));

        if($peminjaman) {
            $peminjaman->status = 2;
            $peminjaman->save();
        }
        
        return response()->json($peminjaman);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function show(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengembalian $pengembalian)
    {
        //
    }
}
