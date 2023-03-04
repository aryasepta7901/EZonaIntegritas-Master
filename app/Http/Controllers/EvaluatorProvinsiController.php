<?php

namespace App\Http\Controllers;

use App\Models\Rekapitulasi;
use App\Models\RekapPilar;
use App\Models\RekapHasil;
use App\Models\Pilar;
use App\Models\SubPilar;
use App\Models\SubRincian;
use App\Models\Pengawasan;

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

    public function show(Rekapitulasi $evaluasi)
    {
        $this->authorize('EvalProv');

        return view('self-assessment.lke', [
            'master' => 'Evaluasi Provinsi ',
            'link' => 'prov/evaluasi',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $evaluasi,
            'subrincian' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianhasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'nilaiPilar' => RekapPilar::where('rekapitulasi_id', $evaluasi->id)->get(),
            'nilaiHasil' => RekapHasil::where('satker_id', $evaluasi->satker_id)->sum('nilai'),

        ]);
    }
    public function show2(Rekapitulasi $evaluasi, Pilar $pilar)
    {
        $this->authorize('EvalProv');
        return view('self-assessment.pertanyaan', [
            'master' => 'LKE ',
            'link' => 'prov/evaluasi/' . $evaluasi->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'rekap' => $evaluasi,


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
    public function update(Request $request, Rekapitulasi $evaluasi)
    {

        $id = $request->id;

        Rekapitulasi::where('id', $id)->update(['status' => $request->status]);
        if ($request->pengawasan_id) {
            Pengawasan::where('id', $request->pengawasan_id)->update(['status' => $request->statusPengawasan]);
        }
        if ($evaluasi->status == 4 || $evaluasi->status == 5) {
            // Jika dilakukan TPI
            return redirect('/tpi/evaluasi')->with('success', 'LKE Berhasil Di Kirim');
        } else {
            // Jika dilakukan provinsi 
            return redirect('/prov/evaluasi')->with('success', 'LKE Berhasil Di Kirim');
        }
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
