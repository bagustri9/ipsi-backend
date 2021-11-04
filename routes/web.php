<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::group([
//     'middleware' => ['cors']
// ], function ($router) {
//      //Add you routes here, for example:
//      Route::get("/barang",[BarangController::class, 'index']);
// });

Route::get('/', function () {
    return view('abc');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', function (){
	$contents = Storage::get('public/1635841162.png');
	return $contents;
});
