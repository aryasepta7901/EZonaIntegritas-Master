<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use App\Models\SubRincian;
use Illuminate\Http\Request;

class SubRincianController extends Controller
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
        $validatedData = $request->validate([
            'subRincian'  => 'required|unique:subrincian',
        ], [
            'required' => ':Attribute Wajib Diisi',
            'unique' => ':Attribute Sudah Terdaftar',

        ]);

        $validatedData['rincian_id'] = $request->rincian;
        $validatedData['id'] = $validatedData['rincian_id'] . substr($validatedData['subRincian'], 0, 1);
        $validatedData['bobot'] = 0;

        SubRincian::create($validatedData);

        return redirect()->back()->with('success', 'Subrincian Berhasil ditambahkan');
        // return redirect('/rincian/' . $request->rincian)->with('success', 'New SubRincian Has Ben Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubRincian  $subRincian
     * @return \Illuminate\Http\Response
     */
    public function show(SubRincian $subrincian)
    {
        // $this->authorize('admin');

        // return view(
        //     'lke.pilar',
        //     [
        //         'master' => 'SubRincian LKE ',
        //         'link' => 'rincian/' . substr($subrincian->id, 0, 1),
        //         'title' => 'Pilar LKE: ' . $subrincian->subRincian,
        //         'subrincian' => $subrincian,
        //         'pilar' => Pilar::where('subrincian_id', $subrincian->id)->get(),
        //     ]
        // );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubRincian  $subRincian
     * @return \Illuminate\Http\Response
     */
    public function edit(SubRincian $subRincian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubRincian  $subRincian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubRincian $subrincian)
    {
        $validatedData = $request->validate([
            'subRincian'  => 'required',
        ], [
            'required' => ':Attribute Wajib Diisi',

        ]);


        SubRincian::where('id', $subrincian->id)->update($validatedData);

        return redirect()->back()->with('success', 'SubRincian Berhasil di Update');
        // return redirect('/rincian/' . $request->rincian)->with('success', 'SubRincian Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubRincian  $subRincian
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubRincian $subrincian)
    {
        SubRincian::destroy($subrincian->id);
        return redirect()->back()->with('success', 'SubRincian Berhasil diHapus');
        // return redirect('/rincian/' . $subrincian->rincian_id)->with('success', 'New SubRincian Has Ben Deleted');
    }
}
