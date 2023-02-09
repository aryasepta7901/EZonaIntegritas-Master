<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LKEController;
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
})->name('login')->middleware('guest');
// dashboard
Route::get('/dashboard', function () {
    return view('dashboard', [
        'title' => 'Dashboard'
    ]);
})->name('dashboard')->middleware('auth');


// users
Route::resource('/users', UserController::class)->middleware('auth');
// Wilayah TPI
Route::resource('/tpi', TpiController::class)->middleware('auth');
// pengawasan satker
Route::resource('/pengawasan', PengawasanController::class)->middleware('auth');
// Persyarataan
Route::resource('/persyaratan', PersyaratanController::class)->middleware('auth');

// CRUD LKE
// rincian
Route::resource('/rincian', RincianController::class)->middleware('auth');
// Sub Rincian
Route::resource('/subrincian', SubRincianController::class)->middleware('auth');
// Pilar
Route::resource('/pilar', PilarController::class)->middleware('auth');
// subpilar
Route::resource('/subpilar', SubPilarController::class)->middleware('auth');
// Pertanyaan
Route::resource('/pertanyaan', PertanyaanController::class)->middleware('auth');

// Google 
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('logout', [GoogleController::class, 'logout'])->name('logout');


// LKE
Route::resource('/lke', LKEController::class)->middleware('auth');
