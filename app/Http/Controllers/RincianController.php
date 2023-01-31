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
        return view(
            'lke.rincian',
            [
                'title' => 'Rincian LKE',
                'rincian' => Rincian::all(),

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rincian  $rincian
     * @return \Illuminate\Http\Response
     */
    public function show(Rincian $rincian)
    {

        return view(
            'lke.subRincian',
            [
                'master' => 'Rincian LKE',
                'link' => 'rincian',
                'title' => 'SubRincian LKE : ' . $rincian->rincian,
                'subRincian' => SubRincian::where('rincian_id', $rincian->id)->get(),
            ]
        );
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
        //
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
    }
}
