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
        //anggota_tpi
        $anggota = anggota_tpi::where('anggota', $request->anggota_id)->get();
        $no = 0;
        foreach ($request->satker_id as $key => $satker) {
            $no += 1;
        }
        $data['jumlah_satker'] = $anggota[0]->jumlah_satker + $no;
        anggota_tpi::where('anggota', $request->anggota_id)->update($data);


        // pengawasan_satker
        $validatedData = $request->validate([
            'anggota_id' => 'required',
            'satker_id'  => 'required',
        ]);
        foreach ($request->satker_id as $key => $satker) {
            $data = new Pengawasan();
            $data->id = $validatedData['anggota_id'] . $satker;
            $data->tpi_id = $request->tpi_id;
            $data->anggota_id =  $validatedData['anggota_id'];
            $data->satker_id = $satker;
            $data->status = 0;
            $data->save();
        }
        return redirect('/tpi/' . $request->tpi_id)->with('success', 'New Pengawasan Has Ben Added');
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

        // Update jumlah_satker di tbl anggota_tpi
        $anggota = anggota_tpi::where('anggota', $pengawasan->anggota_id)->get();
        $data['jumlah_satker'] = $anggota[0]->jumlah_satker - 1;
        anggota_tpi::where('anggota', $pengawasan->anggota_id)->update($data);


        Pengawasan::destroy($pengawasan->id);
        return redirect('/tpi/' . $pengawasan->tpi_id)->with('success', 'Pengawasan Has Ben Deleted');
    }
}
