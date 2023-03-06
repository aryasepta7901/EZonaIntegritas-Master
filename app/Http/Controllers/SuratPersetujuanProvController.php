<?php

namespace App\Http\Controllers;

use App\Models\rekapitulasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'rekap' => Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->whereIn('status', [4, 5, 6, 7])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request->validate(
            [
                'surat' => 'required|mimes:pdf|max:2048',

            ],
            [
                'required' => ':attribute  harus di Upload',
                'mimes' => 'Dokumen hanya boleh format :values,',
                'max' => 'Dokumen hanya boleh Berukuran :max,'
            ]
        );
        if ($request->file('surat')) { //cek apakah ada dokumen yang di upload
            // Ambil File lamanya
            $rekap = Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->where('status', 4)->first();
            if ($rekap) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->surat_rekomendasi);
            }
            foreach ($request->id as $key => $id) {

                Rekapitulasi::updateOrCreate(
                    ['id' => $id],
                    [
                        'surat_rekomendasi' =>  $request->file('surat')->store('surat_rekomendasi_prov'),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Surat Rekomendasi Berhasil di Simpan');
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
    public function destroy(rekapitulasi $surat, Request $request)
    {
        $rekap = Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->where('status', 4)->first();


        if ($rekap->surat_rekomendasi) {
            // jika ada file lama maka hapus
            Storage::delete($rekap->surat_rekomendasi);
        }
        foreach ($request->id as $key => $id) {
            Rekapitulasi::updateOrCreate(
                ['id' => $id],
                [
                    'surat_rekomendasi' =>  '',
                ]
            );
        }
        return redirect()->back()->with('success', 'Surat Rekomendai Berhasil di hapus');
    }
}
