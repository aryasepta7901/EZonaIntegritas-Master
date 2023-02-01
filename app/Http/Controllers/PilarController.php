<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use App\Models\SubPilar;
use Illuminate\Http\Request;


class PilarController extends Controller
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
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function show(Pilar $pilar)
    {
        return view(
            'lke.SubPilar',
            [
                'master' => 'SubPilar LKE ',
                'link' => 'subrincian/' . substr($pilar->id, 0, 2),
                'title' => 'SubPilar LKE: ' . $pilar->pilar,
                'pilar' => $pilar,
                'subpilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
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
