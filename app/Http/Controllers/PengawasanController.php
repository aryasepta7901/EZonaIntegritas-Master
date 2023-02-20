<?php

namespace App\Http\Controllers;

use App\Models\anggota_tpi;
use App\Models\Pengawasan;
use Illuminate\Http\Request;

class PengawasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
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

        // pengawasan_satker
        $validatedData = $request->validate(
            [
                'anggota_id' => 'required',
                'satker_id'  => 'required',
            ],
            [
                'anggota_id.required' => 'Anggota TPI Wajib di Pilih',
                'satker_id.required' => 'Wilayah Pengawasan Satuan Kerja wajib di isi',

            ]
        );

        foreach ($request->satker_id as $key => $satker) {
            $id = $validatedData['anggota_id'] . $satker;
            Pengawasan::updateOrCreate(
                ['id' => $id],
                [
                    'tpi_id' =>  $request->tpi_id,
                    'anggota_id' => $validatedData['anggota_id'],
                    'satker_id' =>  $satker,
                    'status' => 0,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data Pengawasan Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function show(Pengawasan $pengawasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengawasan $pengawasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengawasan $pengawasan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengawasan $pengawasan)
    {
        Pengawasan::destroy($pengawasan->id);
        return redirect()->back()->with('success', 'Data Pengawasan Berhasil di Hapus');
    }
}
