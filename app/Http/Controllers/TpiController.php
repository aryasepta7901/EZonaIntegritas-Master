<?php

namespace App\Http\Controllers;

use App\Models\anggota_tpi;
use App\Models\Pengawasan;
use App\Models\Satker;
use App\Models\TPI;
use App\Models\User;
use Illuminate\Http\Request;
use PengawasanSatker;

class TpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view(
            'tpi.index',
            [
                'title' => 'Mengelola Wilayah Tugas',
                'tpi' => tpi::all(),
                'dalnis' => User::where('level_id', 'DL')->get(),
                'ketua_tim' => User::doesntHave('ketua')->where('level_id', 'KT')->get(),
                'anggota' => User::doesntHave('anggota')->where('level_id', 'AT')->get(),


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

        $validatedData = $request->validate([
            'nama' => 'required|unique:tpi', //nip
            'wilayah'  => 'required',
            'dalnis'  => 'required',
            'ketua_tim'  => 'required',


        ]);
        $validatedData['tahun'] = date('Y');
        $validatedData['id'] = strtoupper(str_replace(' ', '', $validatedData['nama']) . $validatedData['tahun']);

        TPI::create($validatedData);


        foreach ($request->anggota as $key => $anggota) {
            $data = new anggota_tpi();
            $data->id = $anggota . date('Y');
            $data->tpi_id =  $validatedData['id'];
            $data->anggota = $anggota;
            $data->jumlah_satker = 0;
            $data->save();
        }


        return redirect('/tpi')->with('success', 'New TIM Has Ben Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TPI  $tPI
     * @return \Illuminate\Http\Response
     */
    public function show(TPI $tpi)
    {
        return view(
            'tpi.pengawasan',
            [
                'master' => 'Mengelola Wilayah Tugas',
                'link' => 'tpi',
                'title' => ' Wilayah pengawasan ' . $tpi->nama,
                'tpi' => $tpi,
                'pengawasan' => Pengawasan::where('tpi_id', $tpi->id)->get(),
                'anggota' => anggota_tpi::where('tpi_id', $tpi->id)->get(),
                'satker' => Satker::doesntHave('pengawasan')->get(),



            ]


        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TPI  $tPI
     * @return \Illuminate\Http\Response
     */
    public function edit(TPI $tPI)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TPI  $tPI
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TPI $tpi)
    {
        //
        $validatedData = $request->validate([
            'nama' => 'required',
            'wilayah'  => 'required',
            'dalnis'  => 'required',
            'ketua_tim'  => 'required',


        ]);
        $validatedData['tahun'] = date('Y');
        $validatedData['id'] = strtoupper(str_replace(' ', '', $validatedData['nama']) . $validatedData['tahun']);

        TPI::where('id', $tpi->id)->update($validatedData);



        foreach ($request->anggota as $key => $anggota) {
            $data = new anggota_tpi();
            $data->id = $anggota . date('Y');
            $data->tpi_id =  $validatedData['id'];
            $data->anggota = $anggota;
            $data->jumlah_satker = 0;
            $data->update();
        }


        return redirect('/tpi')->with('success', ' TIM Has Ben Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TPI  $tPI
     * @return \Illuminate\Http\Response
     */
    public function destroy(TPI $tpi)
    {
        //
        TPI::destroy($tpi->id);
        anggota_tpi::where('tpi_id', $tpi->id)->delete();
        Pengawasan::where('tpi_id', $tpi->id)->delete();
        return redirect('/tpi')->with('success', 'TPI Has Ben Deleted');
    }
}
