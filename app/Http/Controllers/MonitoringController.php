<?php

namespace App\Http\Controllers;

use App\Models\Rincian;
use App\Models\Pertanyaan;
use App\Models\RekapHasil;
use App\Models\SubRincian;
use App\Models\rekapitulasi;
use Illuminate\Http\Request;
use App\Models\RekapPengungkit;
use App\Http\Controllers\Controller;
use App\Models\DeskEvaluation;
use App\Models\Pilar;
use App\Models\SelfAssessment;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'monitoring.index',
            [
                'title' => 'Usulan Zona Integritas',
                'rekap' => rekapitulasi::all(),
                // Filtering akan ada di View
                'nilaiPengungkit' => RekapPengungkit::all(),
                'nilaiHasil' => Rekaphasil::all(),

            ]


        );
    }
    public function lhe(Rekapitulasi $rekapitulasi)
    {
        return view(
            'monitoring.lhe',
            [
                'master' => 'Monitoring ',
                'link' => '/monitoring',
                'title' => 'Laporan Hasil Evaluasi: ',
                'rekap' => $rekapitulasi,
                'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),
                'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', substr($rekapitulasi->id, 0, 4))->get(),
                'rincianPengungkit' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
                'rincianHasil' => Rincian::where('id', 'H')->orderBy('bobot', 'DESC')->get(),

            ]
        );
    }
    public function catatan(Rekapitulasi $rekapitulasi)
    {
        return view('monitoring.catatan', [
            'master' => 'Monitoring',
            'link' => '/monitoring',
            'title' => 'Catatan Reviu',
            'rekap' => $rekapitulasi,
            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
            'DeskEvaluation' => DeskEvaluation::all(),



        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function edit(rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(rekapitulasi $rekapitulasi)
    {
        //
    }
}
