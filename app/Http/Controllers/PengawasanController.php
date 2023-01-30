<?php

namespace App\Http\Controllers;

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
        //
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
        //
        Pengawasan::destroy($pengawasan->id);
        return redirect('/tpi/' . $pengawasan->tpi_id)->with('success', 'Pengawasan Has Ben Deleted');
    }
}
