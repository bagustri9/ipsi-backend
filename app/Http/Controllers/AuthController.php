<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'User',
            'nama_lengkap' => 'Nama Lengkap',
            'phone' => '083',
            'alamat' => 'Alamat',
            'gender' => 'L',
            'tanggal_hahir' => '2021-11-09 13:14:25'
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request -> email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response ([
                'msg' => 'failed to login'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'msg' => "logout"
        ];
    }
}
