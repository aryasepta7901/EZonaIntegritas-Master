<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\Pilar;
use App\Models\RekapHasil;
use App\Models\Satker;
use Illuminate\Http\Request;

class RincianHasilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('admin');
        return view(
            'lke.hasil.index',
            [

                'title' => 'Upload Rincian Hasil ',
                'pilar' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get()

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
        // validasi
        $request->validate(
            [
                'opsi_id' => 'required',
                'satker_id' => 'required',
            ],
            [
                'opsi_id.required' => 'Silahkan Pilih Jawaban',
                'satker_id.required' => 'Silahkan Pilih Satuan Kerja',
            ]
        );
        foreach ($request->satker_id as $key => $satker) {
            $pilar_id = $request->pilar_id;
            $opsi_id = $request->opsi_id;
            $bobot = $request->bobot;
            $nilai = Opsi::where('id', $opsi_id)->first()->bobot * $bobot;
            $id = date('Y') . $satker . $pilar_id;
            RekapHasil::updateOrCreate(
                ['id' => $id],
                [
                    'tahun' => date('Y'),
                    'opsi_id' => $opsi_id,
                    'nilai' => $nilai,
                    'pilar_id' => $pilar_id,
                    'satker_id' => $satker,
                ]
            );
        }
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function show(Pilar $hasil)
    {

        return view(
            'lke.hasil.show',
            [
                'master' => 'Upload Rincian Hasil',
                'link' => 'hasil',
                'title' => 'Upload Dokumen',
                'pilar' => Pilar::where('id', $hasil->id)->first(),
                'hasil' => RekapHasil::where('pilar_id', $hasil->id)->orderBy('nilai', 'DESC')->get(),
                'satker' => Satker::get(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function edit(Pilar $pilar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekapHasil $hasil)
    {
        // validasi
        $request->validate(
            [
                'opsi_id' => 'required',
            ],
            [
                'opsi_id.required' => 'Silahkan Pilih Jawaban',
            ]
        );

        $opsi_id = $request->opsi_id;
        $bobot = $request->bobot;
        $nilai = Opsi::where('id', $opsi_id)->first()->bobot * $bobot;
        $id = $hasil->id;
        RekapHasil::updateOrCreate(
            ['id' => $id],
            [
                'opsi_id' => $opsi_id,
                'nilai' => $nilai,
            ]
        );

        return redirect()->back()->with('success', 'Data Berhasil DiUpdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekapHasil  $RekapHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekapHasil $hasil)
    {
        RekapHasil::destroy($hasil->id);
        return redirect()->back()->with('success', 'Data Berhasil Di Hapus');
    }
}
