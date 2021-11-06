<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Barang::orderBy("id")->get();
        foreach ($datas as $data) {
            $datasGambar = Gambar::where('id_barang', $data->id)->get();
            foreach ($datasGambar as $dataGambar) {
                $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
            }
            $data->gambar = $datasGambar;
        }
        return $datas;
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
        $request->validate([
            'nama_barang' => 'required',
            "tipe_barang" => 'required',
            "kuantitas" => 'required',
            "harga_rental" => 'required',
            "deskripsi" => 'required',
        ]);
        $data = Barang::create([
            'nama_barang' => $request->nama_barang,
            "tipe_barang" => $request->tipe_barang,
            "kuantitas" => $request->kuantitas,
            "harga_rental" => $request->harga_rental,
            "deskripsi" => $request->deskripsi
        ]);
        // return response()->json($request);
        $fileName = "";
        if ($request->hasFile('gambar')) {
            $nomer = 0;
            foreach ($request->file('gambar') as $gambar) {
                $extensi = $gambar->getClientOriginalExtension();
                $fileName = time() . "_" . $nomer++ . '.' . $extensi;
                Gambar::insert([
                    'id_barang' => $data->id,
                    'gambar' => $fileName
                ]);
                $gambar->move(storage_path('app/public/assets/barang'), $fileName);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal'
            ]);
        }

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
        ]);
        if ($request->hasFile('gambar')) {
            $cari = Gambar::where('id_barang', $id)->get();
            foreach ($cari as $gambar) {
                Storage::delete('public/assets/barang/' . $gambar->gambar);
            }
            Gambar::where('id_barang', $id)->delete();
            $nomer = 0;
            foreach ($request->file('gambar') as $gambar) {
                $extensi = $gambar->getClientOriginalExtension();
                $fileName = time() . "_" . $nomer++ . '.' . $extensi;
                Gambar::insert([
                    'id_barang' => $id,
                    'gambar' => $fileName
                ]);
                $gambar->move(storage_path('app/public/assets/barang'), $fileName);
            }
        } else {
        }

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
        Barang::find($id)->delete();
        $cari = Gambar::where('id_barang', $id)->get();
        foreach ($cari as $gambar) {
            Storage::delete('public/assets/barang/' . $gambar->gambar);
        }
        Gambar::where('id_barang', $id)->delete();
    }

    public function filter($id)
    {
        $result = "";
        switch ($id) {
            case 0:
                $result = Barang::orderBy("harga_rental", "asc")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
            case 1:
                $result = Barang::orderBy("harga_rental", "desc")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
            case 2:
                $result = Barang::where("tipe_barang", "Kamera")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
            case 3:
                $result = Barang::where("tipe_barang", "Lensa")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
            case 4:
                $result = Barang::where("tipe_barang", "Audio")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
            case 5:
                $result = Barang::where("tipe_barang", "Lighting")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
            case 6:
                $result = Barang::where("tipe_barang", "Tripod")->get();
                foreach ($result as $data) {
                    $datasGambar = Gambar::where('id_barang', $data->id)->get();
                    foreach ($datasGambar as $dataGambar) {
                        $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
                    }
                    $data->gambar = $datasGambar;
                };
                break;
        }
        return response()->json($result);
    }

    public function find($nama)
    {
        $result = Barang::where("nama_barang", "like", "%$nama%")->get();
        foreach ($result as $data) {
            $datasGambar = Gambar::where('id_barang', $data->id)->get();
            foreach ($datasGambar as $dataGambar) {
                $dataGambar->url = URL::to('/') . Storage::url('public/assets/barang/' . $dataGambar->gambar);
            }
            $data->gambar = $datasGambar;
        };
        return response()->json($result);
    }
}
