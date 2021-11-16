<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors']], function ($router) {
    Route::post('/register',[AuthController::class,'register']);
    Route::get("/barang/search_query={nama}",[BarangController::class, 'find']);
    Route::get("/barang/{id}",[BarangController::class, 'show']);
    Route::get("/barang/{id}/filter",[BarangController::class, 'filter']);
    Route::get("/barang/{id}/delete",[BarangController::class, 'destroy']);
    Route::post("/barang",[BarangController::class, 'store']);
    Route::post("/barang/{id}/update",[BarangController::class, 'update']);
    Route::get("/barang",[BarangController::class, 'index']);
    Route::post("/login",[AuthController::class, 'login']);
    Route::get("/barang",[BarangController::class, 'index']);
    Route::get("/peminjamans",[PeminjamanController::class, 'index']);
    Route::post("/peminjamans/{id}/update",[PeminjamanController::class, 'update']);
    Route::get("/peminjamans/{id}/delete",[PeminjamanController::class, 'destroy']);
    Route::post("/peminjaman",[PeminjamanController::class, 'store']);
    Route::get("/peminjaman/date",[PeminjamanController::class, 'getAllDate']);
    Route::get("/peminjaman/date/{date}",[PeminjamanController::class, 'getDate']);
    Route::get("/peminjaman/{id}",[PeminjamanController::class, 'store']);
    Route::get("/peminjaman/user/{user_id}",[PeminjamanController::class, 'peminjamanByUser']);
});
Route::group(['middleware' => ['cors','auth:sanctum']], function ($router) {
    Route::get("/user/{id}",[UserController::class, 'show']);
    Route::post("/user/{id}/update",[UserController::class, 'update']);
    Route::post("/logout",[AuthController::class, 'logout']);
    Route::post("/user/profile-image/{id}",[UserController::class, 'profileImage']);
});