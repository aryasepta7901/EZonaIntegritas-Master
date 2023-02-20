<?php

namespace App\Http\Controllers;

use App\Models\anggota_tpi;
use App\Models\DeskEvaluation;
use App\Models\Pilar;
use App\Models\SubRincian;
use App\Models\Rekappilar;
use App\Models\Rekaphasil;
use App\Models\Rekapitulasi;
use App\Models\SubPilar;
use Illuminate\Http\Request;

class DeskEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('TPI');
        return view(
            'tpi.index',
            [
                'title' => 'Desk-Evaluation Zona Integritas',
                'anggota' => anggota_tpi::where('anggota_id', auth()->user()->id)->first(),
                // 'rekap' => Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->get(),


            ]

        );
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
     * @param  \App\Models\Rekapitulasi  $Rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $evaluasi)
    {
        $this->authorize('TPI');

        return view('tpi.lke', [
            'master' => 'Desk-Evaluation ',
            'link' => 'tpi/evaluasi',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $evaluasi,
            'subrincian' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianhasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'nilai' => Rekappilar::where('rekapitulasi_id', $evaluasi->id)->sum('nilai'),
            'nilaiHasil' => Rekaphasil::where('satker_id', $evaluasi->satker_id)->sum('nilai'),

        ]);
    }
    public function show2(Rekapitulasi $evaluasi, Pilar $pilar)
    {
        $this->authorize('TPI');
        return view('tpi.pertanyaan', [
            'master' => 'LKE ',
            'link' => 'tpi/evaluasi/' . $evaluasi->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'rekap' => $evaluasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeskEvaluation  $deskEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(DeskEvaluation $deskEvaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeskEvaluation  $deskEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeskEvaluation $deskEvaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeskEvaluation  $deskEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeskEvaluation $deskEvaluation)
    {
        //
    }
}
