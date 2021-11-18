<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        $foto = Storage::url('public/assets/user/' . $user->image);
        if ($foto) {
            $user->gambar = URL::to('/') . $foto;
        } else {
            $user->gambar = null;
        }
        return $user;
    }

    public function profileImage(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            $extensi = $request->image->getClientOriginalExtension();
            $user = User::find($id);
            $fileName = time() . '.' . $extensi;
            $user->image = $fileName;
            $user->save();
            $request->image->move(storage_path('app/public/assets/user'), $fileName);
            return response()->json($user);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $updated = User::find($id)->update([
            "email" => $request->input('email'),
            "password" => Hash::make($request->password),
            "role" => $request->input('role'),
            "nama_lengkap" => $request->input('nama_lengkap'),
            "phone" => $request->input('phone'),
            "alamat" => $request->input('alamat'),
            "gender" => $request->input('gender'),
            "tanggal_hahir" => $request->input('tanggal_hahir'),
        ]);
        // $user = User::where('id', $id)->firstOrFail();
        // $user->fill(\Input::all());
        // $user->save();
        return response()->json($updated);
    }
}
