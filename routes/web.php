<?php

use App\Http\Controllers\DeskEvaluationController;
use App\Http\Controllers\EvaluatorProvinsiController;
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
use App\Http\Controllers\RincianHasilController;
use App\Http\Controllers\SelfAssessmentController;
use App\Http\Controllers\SuratPersetujuanProvController;

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
Route::resource('/tim', TpiController::class)->middleware('auth');
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
Route::post('login', [GoogleController::class, 'login'])->name('login');
Route::get('logout', [GoogleController::class, 'logout'])->name('logout');

// LKE
Route::resource('/lke', LKEController::class)->middleware('auth');
Route::get('lke/{lke}/{pilar}', [LKEController::class, 'show2'])->name('lke.show2')->middleware('auth');
// Self Assessment
Route::resource('/selfAssessment', SelfAssessmentController::class)->middleware('auth');
// Upload Rincian hasil
Route::resource('/hasil', RincianHasilController::class)->middleware('auth');

// Evaluator Provinsi
Route::resource('/prov/evaluasi', EvaluatorProvinsiController::class)->middleware('auth');
Route::get('/prov/evaluasi/{evaluasi}/{pilar}', [EvaluatorProvinsiController::class, 'show2'])->name('evaluasi.show2')->middleware('auth');
// Surat Persetujuan BPS Provinsi
Route::resource('/prov/surat', SuratPersetujuanProvController::class)->middleware('auth');

// Desk Evaluation
Route::resource('/tpi/evaluasi', DeskEvaluationController::class)->middleware('auth');
