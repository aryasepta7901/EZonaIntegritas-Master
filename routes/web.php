<?php

use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\TpiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
// users
Route::resource('/users', UserController::class);
// Wilayah TPI
Route::resource('/tpi', TpiController::class);
// pengawasan satker
Route::resource('/pengawasan', PengawasanController::class);
