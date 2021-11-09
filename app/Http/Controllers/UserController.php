<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function login(Request $request) {
        try {
            $login = User::where('username', $request -> username)->where('password', Crypt::decryptString($request -> password));
        }
        catch (DecryptException $e) {
        }
        return $login;
    }
}
