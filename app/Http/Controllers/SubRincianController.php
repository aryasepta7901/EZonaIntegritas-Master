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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubRincian  $subRincian
     * @return \Illuminate\Http\Response
     */
    public function show(SubRincian $subrincian)
    {
        return view(
            'lke.pilar',
            [
                'master' => 'SubRincian LKE ',
                'link' => 'rincian/' . substr($subrincian->id, 0, 1),
                'title' => 'Pilar LKE: ' . $subrincian->subRincian,
                'subrincian' => $subrincian,
                'pilar' => Pilar::where('subpilar_id', $subrincian->id)->get(),
            ]
        );
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
    public function update(Request $request, SubRincian $subRincian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubRincian  $subRincian
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubRincian $subRincian)
    {
        //
    }
}
