<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::orderBy("id")->get();
        return response()->json($data);
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
        return response()->json($request);
        $fileName = "";
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extensi = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extensi;
            $path = Storage::putFileAs(
                'barang', $file, $fileName
            );
            return $path;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal'
            ]);
        }
        $request->validate([
            'nama_barang' => 'required',
            "tipe_barang" => 'required',
            "kuantitas" => 'required',
            "harga_rental" => 'required',
            "deskripsi" => 'required',
        ]);
        $data = Barang::insert([
            'nama_barang' => $request->nama_barang,
            "tipe_barang" => $request->tipe_barang,
            "kuantitas" => $request->kuantitas,
            "harga_rental" => $request->harga_rental,
            "deskripsi" => $request->deskripsi,
            "gambar" => $fileName
        ]);

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hasil = Barang::where('id', $id)->first();
        return response()->json($hasil);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cari = Barang::find($id)->first();
        $fileName = "";
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extensi = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extensi;
            $file->move(public_path('assets/barang'), $fileName);
        }
        else{
            $fileName = $cari->gambar;
        }
        $updated = Barang::find($id)->update([
            "nama_barang" => $request->input('nama_barang'),
            "tipe_barang" => $request->input('tipe_barang'),
            "kuantitas" => $request->input('kuantitas'),
            "harga_rental" => $request->input('harga_rental'),
            "deskripsi" => $request->input('deskripsi'),
            "gambar" => $fileName
        ]);

        return response()->json($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Barang::find($id)->delete();
        return response()->json($deleted);
    }
}
