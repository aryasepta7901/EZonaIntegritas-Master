<?php

use App\Http\Controllers\DeskEvaluationController;
use App\Http\Controllers\EvaluatorProvinsiController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LheController;
use App\Http\Controllers\LKEController;
use App\Http\Controllers\MonitoringController;
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
use App\Http\Controllers\RekapitulasiController;
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

// landingPage
Route::get('/', function () {
    return view('landingPage.index');
})->name('landingPage')->middleware('guest');
// login
Route::get('/login', function () {
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
Route::post('/users/import', [UserController::class, 'import'])->name('import.import');

// Wilayah TPI
Route::resource('/tim', TpiController::class)->middleware('auth');
Route::post('/tim/import', [TpiController::class, 'import'])->name('import.import');

// pengawasan satker
Route::resource('/pengawasan', PengawasanController::class)->middleware('auth');
// Persyarataan
Route::resource('/persyaratan', PersyaratanController::class)->middleware('auth');
Route::post('/persyaratan/import', [PersyaratanController::class, 'import'])->name('import.import');

// CRUD LKE
// rincian
Route::resource('/rincian', RincianController::class)->middleware('auth');
// // Sub Rincian
Route::resource('/subrincian', SubRincianController::class)->middleware('auth');
// // Pilar
Route::resource('/pilar', PilarController::class)->middleware('auth');
// // subpilar
Route::resource('/subpilar', SubPilarController::class)->middleware('auth');
// // Pertanyaan
Route::resource('/pertanyaan', PertanyaanController::class)->middleware('auth');
Route::resource('/pertanyaan', PertanyaanController::class)->middleware('auth');
// Google 
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('login', [GoogleController::class, 'login'])->name('login');
Route::get('logout', [GoogleController::class, 'logout'])->name('logout');

// LKE
Route::resource('satker/lke', LKEController::class)->middleware('auth');
Route::get('satker/lke/{lke}/{pilar}', [LKEController::class, 'pertanyaan'])->name('lke.pertanyaan')->middleware('auth');
Route::resource('satker/rekapitulasi', RekapitulasiController::class)->middleware('auth');
Route::get('satker/rekap2/{rekapitulasi}', [RekapitulasiController::class, 'rekap2'])->middleware('auth');
Route::get('satker/rekap3/{rekapitulasi}', [RekapitulasiController::class, 'rekap3'])->middleware('auth');
Route::get('satker/surat/{rekapitulasi}', [RekapitulasiController::class, 'surat'])->middleware('auth');
Route::post('satker/surat/cetak', [RekapitulasiController::class, 'cetak'])->middleware('auth');

// Self Assessment
Route::resource('/selfAssessment', SelfAssessmentController::class)->middleware('auth');
// Upload Rincian hasil
Route::resource('/hasil', RincianHasilController::class)->middleware('auth');
Route::post('/hasil/import', [RincianHasilController::class, 'import'])->name('import.import');

// Evaluator Provinsi
Route::resource('/prov/evaluasi', EvaluatorProvinsiController::class)->middleware('auth');
Route::get('/prov/evaluasi/{evaluasi}/{pilar}', [EvaluatorProvinsiController::class, 'pertanyaan'])->name('evaluasi.pertanyaan')->middleware('auth');
// Surat Persetujuan BPS Provinsi
Route::resource('/prov/surat', SuratPersetujuanProvController::class)->middleware('auth');
Route::post('/prov/surat/cetak', [SuratPersetujuanProvController::class, 'cetak'])->name('cetak.cetak')->middleware('auth');


// Desk Evaluation
Route::resource('/tpi/evaluasi', DeskEvaluationController::class)->middleware('auth');
Route::get('/tpi/evaluasi/{evaluasi}/{pilar}', [DeskEvaluationController::class, 'pertanyaan'])->name('evaluasi.pertanyaan')->middleware('auth');
// LHE dan cetak LHE
Route::resource('/tpi/lhe', LheController::class)->middleware('auth');


// Monitoring
Route::resource('/monitoring', MonitoringController::class)->middleware('auth')->only(['index']);
Route::get('/monitoring/lhe/{rekapitulasi}', [MonitoringController::class, 'lhe'])->middleware('auth');
Route::get('/monitoring/catatan/{rekapitulasi}', [MonitoringController::class, 'catatan'])->middleware('auth');
