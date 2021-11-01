<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

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
            if ($request->file('gambar')->isValid()) {
                $file = $request->file('gambar');
                $extensi = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extensi;
                $file->move(public_path('assets/barang'), $fileName);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'ukuran file terlalu besar'
                ]);
            }
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
            "gambar" => 'required'
        ]);
        $data = Barang::create(array_merge($request->all(), ['gambar' => $fileName]));

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
        $updated = Barang::find($id)->update([
            "nama_barang" => $request->input('nama_barang'),
            "tipe_barang" => $request->input('tipe_barang'),
            "kuantitas" => $request->input('kuantitas'),
            "harga_rental" => $request->input('harga_rental'),
            "deskripsi" => $request->input('deskripsi'),
            "gambar" => $request->input('gambar')
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
