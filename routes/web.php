<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TpiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PilarController;
use App\Http\Controllers\RincianController;
use App\Http\Controllers\SubPilarController;
use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\SubRincianController;
use App\Http\Controllers\PersyaratanController;

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

// login
Route::get('/', function () {
    return view('login');
});
// users
Route::resource('/users', UserController::class);
// Wilayah TPI
Route::resource('/tpi', TpiController::class);
// pengawasan satker
Route::resource('/pengawasan', PengawasanController::class);
// Persyarataan
Route::resource('/persyaratan', PersyaratanController::class);

// CRUD LKE
// rincian
Route::resource('/rincian', RincianController::class);
// Sub Rincian
Route::resource('/subrincian', SubRincianController::class);
// Pilar
Route::resource('/pilar', PilarController::class);
// subpilar
Route::resource('/subpilar', SubPilarController::class);
// Pertanyaan
Route::resource('/pertanyaan', PertanyaanController::class);
