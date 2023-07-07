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
                'tpi' => tpi::orderBy('wilayah', 'asc')->get(),
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
                'nama' => 'required|max:5',
                'wilayah'  => 'required',
                'dalnis'  => 'required',
                'ketua_tim'  => 'required',
                'anggota' => 'required',
            ],
            [
                'required' => ':attribute Wajib di Isi',
                'max' => ':attribute hanya boleh maksimal 4 karakter, contoh:Tim 1',
            ]
        );
        // TPI
        $nama = $request->nama;
        $wilayah = $request->wilayah;
        $tahun = date('Y');
        $id = strtoupper(str_replace(' ', '', $nama . $tahun .  'wil' . $wilayah));
        $tpi = TPI::where('id', $id)->first();

        if ($tpi == null) {
            // cek apakah id sudah terdaftar
            $data = [
                'id' =>  $id,
                'tahun' => $tahun,
                'nama' => $nama,
                'dalnis' => $request->dalnis,
                'ketua_tim' => $request->ketua_tim,
                'wilayah' => $wilayah,
            ];
            TPI::create($data);
        } else {
            return back()->withErrors('ID Sudah Terdaftar');
        }

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

        $request->validate(
            [
                'nama' => 'required|max:5',
                'wilayah'  => 'required',
                'dalnis'  => 'required',
                'ketua_tim'  => 'required',
                'anggota'  => 'required',
            ],
            [
                'required' => ':attribute Wajib di Isi',
                'max' => ':attribute hanya boleh maksimal 4 karakter, contoh:Tim 1',

            ]
        );
        $nama = $request->nama;
        $wilayah = $request->wilayah;
        $tahun = date('Y');
        $tpi_id = strtoupper(str_replace(' ', '', $nama . $tahun .  'wil' . $wilayah));

        // cek apakah id lama sama baru berbeda
        if ($tim->id == $tpi_id) {
            // Jika sama maka
            $data = [
                'id' =>  $tpi_id,
                'tahun' => $tahun,
                'nama' => $nama,
                'dalnis' => $request->dalnis,
                'ketua_tim' => $request->ketua_tim,
                'wilayah' => $wilayah,
            ];
            TPI::where('id', $tpi_id)->update($data);
        } else {
            $tpi = TPI::where('id', $tpi_id)->first();
            if ($tpi == null) {
                TPI::where('id', $tim->id)->delete(); //delete data lama
                $data = [
                    'id' =>  $tpi_id,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'dalnis' => $request->dalnis,
                    'ketua_tim' => $request->ketua_tim,
                    'wilayah' => $wilayah,
                ];
                TPI::create($data);
            } else {
                return back()->withErrors('ID Sudah Terdaftar');
            }
        }
        // Anggota TPI

        anggota_tpi::where('tpi_id', $tim->id)->delete(); //delete data lama
        foreach ($request->anggota as $key => $anggota) {
            $id = $anggota . date('Y');
            anggota_tpi::updateOrCreate(
                ['id' => $id],
                [
                    'tpi_id' =>  $tpi_id,
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
        return redirect()->back()->with('success', 'TPI Berhasil di Hapus');
    }
}
