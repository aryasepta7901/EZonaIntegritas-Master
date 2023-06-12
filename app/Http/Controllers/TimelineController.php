<?php

namespace App\Http\Controllers;

use App\Models\StatusRekap;
use App\Models\timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
        //
        return view(
            'index',
            [
                'title' => 'Mengelola schedule',
                'status' => StatusRekap::all(),

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
     * @param  \App\Models\timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function show(timeline $timeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function edit(timeline $timeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, timeline $timeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(timeline $timeline)
    {
        //
    }
}
