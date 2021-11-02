<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=> "User",
            'nama_lengkap'=>$request->nama_lengkap,
            'phone'=>$request->phone,
            'alamat'=>$request->alamat,
            'gender'=>$request->gender,
            'tanggal_hahir'=>$request->tanggal_hahir,
        ]);

        $token = $user->createToken($user->email.'_Token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'username' => $user->username,
            'token' => $token
        ]);
    }
}
