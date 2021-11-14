<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
}
