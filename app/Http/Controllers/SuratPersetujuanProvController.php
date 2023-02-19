<?php

namespace App\Http\Controllers;

use App\Models\rekapitulasi;
use Illuminate\Http\Request;

class SuratPersetujuanProvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('EvalProv');

        return view('EvalProv.surat', [
            'master' => 'Rekapitulasi',
            'link' => 'prov/evaluasi',
            'title' => 'Surat Persetujuan',
            'rekap' => Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->where('status', 4)->get(),
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
