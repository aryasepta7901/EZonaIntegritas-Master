<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use App\Models\RekapHasil;
use Illuminate\Http\Request;

class RincianHasilController extends Controller
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
            'lke.hasil.index',
            [

                'title' => 'Upload Rincian Hasil ',
                'pilar' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get()

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
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function show(Pilar $hasil)
    {

        return view(
            'lke.hasil.show',
            [
                'title' => 'Upload Dokumen',
                'pilar' => Pilar::where('id', $hasil->id)->first(),
                'hasil' => RekapHasil::where('pilar_id', $hasil->id)->get(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function edit(Pilar $pilar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pilar $pilar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pilar $pilar)
    {
        //
    }
}
