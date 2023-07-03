<?php

namespace App\Http\Controllers;

use App\Imports\RekapHasilImport;
use App\Imports\RincianHasilImport;
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
                'pilar' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
                'hasilSatker' => RekapHasil::select('satker_id')->orderBy('nilai', 'DESC')->groupBy('satker_id')->get(), //ambil satker yang sudah digroupBy
                'hasil' => RekapHasil::where('tahun', date('Y'))->get(), //ambil semua nilai hasil
                'satker' => Satker::doesntHave('RekapHasil')->get(),



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
                'satker_id' => 'required',

            ],
            [
                'satker_id.required' => 'Silahkan Pilih Satuan Kerja',
            ]
        );
        $pilar = Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get();
        foreach ($request->satker_id as $key => $satker) {
            foreach ($pilar as $value) {
                $hasil = $value->id;
                $pilar_id = $request->input('pilar_id' . $hasil);
                $opsi_id = $request->$hasil;
                $bobot =  $request->input('bobot' . $hasil);
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
        }
        return redirect()->back()->with('success', 'Data Berhasil Ditambahkan');
    }
    public function import(Request $request)
    {
        $file = $request->file('excel');

        $import = new RekapHasilImport;
        $import->import($file);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect()->back()->with('success', 'Data Berhasil di Import');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function show(Pilar $hasil)
    {
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
     * @param  \App\Models\Satker  $pilar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Satker $hasil)
    {
        $satker = $hasil->id;
        $pilar = Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get();
        foreach ($pilar as $value) {
            $hasil = $value->id;
            $satker = $satker;
            $pilar_id = $request->input('pilar_id' . $hasil);
            $opsi_id = $request->$hasil;
            $bobot =  $request->input('bobot' . $hasil);
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

        return redirect()->back()->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekapHasil  $RekapHasil
     * @param  \App\Models\Satker  $Satker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satker $hasil)
    {
        RekapHasil::where('satker_id', $hasil->id)->delete();
        return redirect()->back()->with('success', 'Data Berhasil Di Hapus');
    }
}
