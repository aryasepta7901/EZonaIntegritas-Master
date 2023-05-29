<?php

namespace App\Http\Controllers;

use App\Imports\TpiImport;
use App\Models\anggota_tpi;
use App\Models\Pengawasan;
use App\Models\Satker;
use App\Models\TPI;
use App\Models\User;
use Illuminate\Http\Request;

class TpiController extends Controller
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
            'tim.index',
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
        // validasi
        $request->validate(
            [
                'id' => 'unique:tpi',
                'nama' => 'required',
                'wilayah'  => 'required',
                'dalnis'  => 'required',
                'ketua_tim'  => 'required',
                'anggota' => 'required',
            ],
            [
                'required' => ':attribute Wajib di Isi',
                'unique' => ':Attribute Sudah Terdaftar',
            ]
        );

        // TPI
        $tahun = date('Y');
        $nama = $request->nama;
        $wilayah = $request->wilayah;
        $data = [
            'id' => strtoupper(str_replace(' ', '', $nama . $tahun .  'wil' . $wilayah)),
            'tahun' => $tahun,
            'nama' => $nama,
            'dalnis' => $request->dalnis,
            'ketua_tim' => $request->ketua_tim,
            'wilayah' => $wilayah,
        ];
        TPI::create($data);

        // Anggota TPI
        foreach ($request->anggota as $key => $anggota) {
            $id = $anggota . $tahun;
            anggota_tpi::updateOrCreate(
                ['id' => $id],
                [
                    'tpi_id' =>  $data['id'],
                    'anggota_id' => $anggota,
                ]
            );
        }
        return redirect()->back()->with('success', 'TPI Berhasil di Tambahkan');
    }

    public function import(Request $request)
    {

        $file = $request->file('excel');

        $import = new TpiImport;
        $import->import($file);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect('/tim')->with('success', 'Data Berhasil di Import');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TPI  $tPI
     * @return \Illuminate\Http\Response
     */
    public function show(TPI $tim)
    {

        return view(
            'tim.pengawasan',
            [
                'master' => 'Mengelola Wilayah Tugas',
                'link' => '/tim',
                'title' => ' Wilayah pengawasan ' . $tim->nama,
                'tpi' => $tim,
                'pengawasan' => Pengawasan::where('tpi_id', $tim->id)->get(),
                'anggota' => anggota_tpi::where('tpi_id', $tim->id)->get(),
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
    public function update(Request $request, TPI $tim)
    {

        $validatedData = $request->validate(
            [
                'id' => 'unique:tpi',
                'nama' => 'required',
                'wilayah'  => 'required',
                'dalnis'  => 'required',
                'ketua_tim'  => 'required',

            ],
            [
                'required' => ':attribute Wajib di Isi',
                'unique' => ':Attribute Sudah Terdaftar',
            ]
        );
        $validatedData['tahun'] = date('Y');
        $validatedData['id'] = strtoupper(str_replace(' ', '', $validatedData['nama']) . $validatedData['tahun'] .  'wil' . $validatedData['wilayah']);

        TPI::where('id', $tim->id)->update($validatedData);


        // Anggota TPI
        $request->validate(
            [
                'anggota'  => 'required',
            ],
            [
                'required' => ':attribute Wajib di Isi',
            ]
        );
        $anggota = anggota_tpi::where('tpi_id', $tim->id)->delete();
        foreach ($request->anggota as $key => $anggota) {
            $id = $anggota . date('Y');
            anggota_tpi::updateOrCreate(
                ['id' => $id],
                [
                    'tpi_id' =>  $validatedData['id'],
                    'anggota_id' => $anggota,
                ]
            );
        }
        return redirect()->back()->with('success', ' TPI berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TPI  $tPI
     * @return \Illuminate\Http\Response
     */
    public function destroy(TPI $tim)
    {

        TPI::destroy($tim->id);
        anggota_tpi::where('tpi_id', $tim->id)->delete();
        Pengawasan::where('tpi_id', $tim->id)->delete();
        return redirect()->back()->with('success', 'TPI Berhasil di Hapus');
    }
}
