<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use App\Models\Pertanyaan;
use App\Models\RekapHasil;
use App\Models\SubRincian;
use App\Models\Rekapitulasi;
use Illuminate\Http\Request;
use App\Models\DeskEvaluation;
use App\Models\SelfAssessment;
use App\Models\RekapPengungkit;
use App\Http\Controllers\Controller;
use App\Models\Rincian;

class RekapitulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $rekapitulasi)
    {
        $this->authorize('pic');
        return view('self-assessment.cetak', [
            'master' => 'Rekapitulasi',
            'link' => 'lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $rekapitulasi->predikat,
            'rekap' => $rekapitulasi,
            'pertanyaan' => Pertanyaan::count(),
            'rincianPengungkit' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianHasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'selfAssessment' => SelfAssessment::where('rekapitulasi_id', $rekapitulasi->id)->count(),
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $rekapitulasi->id)->count('jawaban_dl'),
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),
            'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', date('Y'))->get(),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),


        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekapitulasi $rekapitulasi)
    {
        //
    }
}
