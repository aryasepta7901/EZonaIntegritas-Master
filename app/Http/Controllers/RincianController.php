<?php

namespace App\Http\Controllers;

use App\Models\Rincian;
use App\Models\SubRincian;
use Illuminate\Http\Request;

class RincianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // $this->authorize('admin');

        // return view(
        //     'lke.rincian',
        //     [
        //         'title' => 'Rincian LKE',
        //         'rincian' => Rincian::orderBy('id', 'DESC')->get(),

        //     ]
        // );
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
            'rincian'  => 'required|unique:rincian',
        ], [
            'required' => ':Attribute Wajib Diisi',
            'unique' => ':Attribute Sudah Terdaftar',

        ]);
        $id = substr($validatedData['rincian'], 0, 1);

        $rincian = Rincian::where('id', $id)->first(); //cek apakah id ada yang sama
        if ($rincian) {
            // Jika ID sudah terdaftar
            $ascii = ord($id) + 1;
            $validatedData['id'] = chr($ascii);
        } else {
            // Jika ID belum terdaftar
            $validatedData['id'] = $id;
        }
        $validatedData['bobot'] = 0;
        Rincian::create($validatedData);

        return redirect('/pertanyaan')->with('success', 'Rincian Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rincian  $rincian
     * @return \Illuminate\Http\Response
     */
    public function show(Rincian $rincian)
    {
        // $this->authorize('admin');

        // return view(
        //     'lke.subRincian',
        //     [
        //         'master' => 'Rincian LKE',
        //         'link' => 'rincian',
        //         'title' => 'SubRincian LKE : ' . $rincian->rincian,
        //         'rincian' => $rincian,
        //         'subRincian' => SubRincian::where('rincian_id', $rincian->id)->get(),
        //     ]
        // );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rincian  $rincian
     * @return \Illuminate\Http\Response
     */
    public function edit(Rincian $rincian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rincian  $rincian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rincian $rincian)
    {
        $validatedData = $request->validate(
            [
                'rincian'  => 'required',
            ],
            [
                'required' => ':Attribute Wajib Diisi',

            ]
        );

        Rincian::where('id', $rincian->id)->update($validatedData);

        return redirect('/pertanyaan')->with('success', 'Rincian Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rincian  $rincian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rincian $rincian)
    {
        //
        Rincian::destroy($rincian->id);
        return redirect('/pertanyaan')->with('success', 'Rincian Berhasil di Hapus');
    }
}
