<?php

namespace App\Http\Controllers;

use App\Models\Persyaratan;
use App\Models\Pertanyaan;
use App\Models\RekapHasil;
use App\Models\Rekapitulasi;
use App\Models\TPI;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'user' => User::count(),
            'tpi' => TPI::count(),
            'persyaratan' => Persyaratan::count(),
            'pertanyaan' => Pertanyaan::count(),
            'rincianHasil' => RekapHasil::select('satker_id')->groupby('satker_id')->get()->count(),
            'pengajuan' => Rekapitulasi::count(),
        ]);
    }
}
