<?php

namespace App\Http\Controllers;

use App\Models\Persyaratan;
use App\Models\Pilar;
use App\Models\Rekapitulasi;
use App\Models\RekapPilar;
use App\Models\SelfAssessment;
use App\Models\SubPilar;
use App\Models\SubRincian;
use Illuminate\Http\Request;

class LKEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('pic');

        return view('self-assessment.rekap', [
            'title' => 'Rekapitulasi Lembar Kerja Evaluasi',
            'persyaratan' => Persyaratan::where('satker_id', auth()->user()->satker_id)->where('tahun', date('Y'))->first(),
            'rekap' => Rekapitulasi::where('satker_id', auth()->user()->satker_id)->get(),
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
        $data = [
            'predikat' => $request->predikat,
            'tahun' => date('Y'),
            'satker_id' => $request->satker_id,
        ];
        $data['id'] = $data['tahun'] . $data['predikat'] . $data['satker_id'];

        Rekapitulasi::create($data);

        return redirect('/lke')->with('success', 'Pengajuan Berhasil di Buat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $lke)
    {
        $this->authorize('pic');

        return view('self-assessment.lke', [
            'master' => 'Rekapitulasi ',
            'link' => 'lke/',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $lke,
            'subrincian' => SubRincian::where('rincian_id', 'p')->get(),
            'nilai' => RekapPilar::where('rekapitulasi_id', $lke->id)->sum('nilai'),

        ]);
    }
    public function show2(Rekapitulasi $lke, Pilar $pilar)
    {
        $this->authorize('pic');

        return view('self-assessment.pertanyaan', [
            'master' => 'LKE ',
            'link' => 'lke/' . $lke->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'lke' => $lke,


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
