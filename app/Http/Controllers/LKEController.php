<?php

namespace App\Http\Controllers;

use App\Models\Persyaratan;
use App\Models\Pilar;
use App\Models\Rekapitulasi;
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
        $validatedData['predikat'] = $request->predikat;
        $validatedData['tahun'] = date('Y');
        $validatedData['satker_id'] = $request->satker_id;

        $validatedData['id'] = $validatedData['tahun'] . $validatedData['predikat'] . $validatedData['satker_id'];

        Rekapitulasi::create($validatedData);

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

        return view('self-assessment.lke', [
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $lke,
            'subrincian' => SubRincian::where('rincian_id', 'p')->get(),

        ]);
    }
    public function show2(Rekapitulasi $lke, Pilar $pilar)
    {
        return view('self-assessment.pertanyaan', [
            'title' => $pilar->pilar,
            'pilar' => $pilar,

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
