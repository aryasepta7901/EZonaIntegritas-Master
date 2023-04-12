<?php

namespace App\Http\Controllers;

use App\Models\rekapitulasi;
use App\Models\RekapHasil;
use App\Models\RekapPengungkit;
use Illuminate\Http\Request;

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
                'title' => 'Usulan ZI Tahun ' . date('Y'),
                'rekap' => rekapitulasi::all(),
                'nilaiPengungkit' => RekapPengungkit::all(),
                'nilaiHasil' => Rekaphasil::where('tahun', date('Y'))->get(),

            ]


        );
    }
    public function lhe()
    {
        dd('Hai');
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
