<?php

namespace App\Http\Controllers;

use App\Imports\PersyaratanImport;
use App\Models\persyaratan;
use App\Models\Satker;
use Illuminate\Http\Request;
use Persyaratan as GlobalPersyaratan;

class PersyaratanController extends Controller
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
            'persyaratan.index',
            [
                'title' => 'Mengelola Persyaratan WBK/WBBM',
                'persyaratan' => Persyaratan::where('tahun', date('Y'))->get(),
                'satker' => Satker::doesntHave('persyaratan')->get(),
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
        $request->validate(
            [
                'satker_id' => 'required',
                'persyaratan' => 'required'
            ],
            ['required' => ':Attribute Wajib Diisi',],
        );

        // Satker_id
        foreach ($request->satker_id as $key => $satker_id) {
            $tahun = date('Y');
            $id = $satker_id . $tahun;
            if ($request->persyaratan == 'wbk') {
                // Jika yang dipilih WBK
                $wbk = 1;
                $wbbm = 0;
            } else {
                // Jika yang dipilih WBBM , maka bisa mengajukan keduanya
                $wbk = 1;
                $wbbm = 1;
            }
            persyaratan::updateOrCreate(
                ['id' => $id],
                [
                    'tahun' =>  $tahun,
                    'satker_id' => $satker_id,
                    'wbk' => $wbk,
                    'wbbm' => $wbbm,
                ]
            );
        }
        return redirect()->back()->with('success', 'Persyaratan Berhasil di Tambahkan');
    }
    public function import(Request $request)
    {
        $file = $request->file('excel');

        $import = new PersyaratanImport;
        $import->import($file);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return redirect()->back()->with('success', 'Data Berhasil di Import');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function show(persyaratan $persyaratan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function edit(persyaratan $persyaratan)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, persyaratan $persyaratan)
    {
        $validatedData['satker_id'] = $persyaratan->satker_id;
        $validatedData['tahun'] = date('Y');

        $validatedData['id'] = $validatedData['satker_id'] . $validatedData['tahun'];

        if ($request->persyaratan == 'wbk') {
            // Jika yang dipilih WBK
            $validatedData['wbk'] = 1;
            $validatedData['wbbm'] = 0;
        } else {
            // Jika yang dipilih WBBM , maka bisa mengajukan keduanya
            $validatedData['wbk'] = 1;
            $validatedData['wbbm'] = 1;
        }

        persyaratan::where('id', $persyaratan->id)->update($validatedData);

        return redirect()->back()->with('success', 'Persyaratan Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function destroy(persyaratan $persyaratan)
    {
        persyaratan::destroy($persyaratan->id);
        return redirect()->back()->with('success', 'Persyaratan Berhasil di Hapus');
    }
}
