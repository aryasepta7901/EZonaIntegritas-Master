<?php

namespace App\Http\Controllers;

use App\Models\Rekapitulasi;
use App\Models\RekapPilar;
use App\Models\Pilar;
use App\Models\SubPilar;
use App\Models\SubRincian;
use Illuminate\Http\Request;


class EvaluatorProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('EvalProv');


        return view('EvalProv.rekap', [
            'title' => 'Rekapitulasi Pengajuan Zona Integritas',
            'rekap' => Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->get(),
        ]);
    }
    public function cetak()
    {
        dd('cek');
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

    public function show(Rekapitulasi $prov)
    {
        $this->authorize('EvalProv');

        return view('self-assessment.lke', [
            'master' => 'Evaluasi Provinsi ',
            'link' => 'evaluasi/prov/',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $prov,
            'subrincian' => SubRincian::where('rincian_id', 'p')->get(),
            'nilai' => RekapPilar::where('rekapitulasi_id', $prov->id)->sum('nilai'),

        ]);
    }
    public function show2(Rekapitulasi $prov, Pilar $pilar)
    {
        $this->authorize('EvalProv');
        return view('self-assessment.pertanyaan', [
            'master' => 'LKE ',
            'link' => 'evaluasi/prov/' . $prov->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'rekap' => $prov,


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
        $id = $request->id;
        Rekapitulasi::where('id', $id)->update(['status' => $request->status]);
        return redirect('/evaluasi/prov')->with('success', 'LKE Berhasil Di Kirim');
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
