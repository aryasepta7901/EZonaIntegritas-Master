<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\SelfAssessment;
use Illuminate\Http\Request;

class SelfAssessmentController extends Controller
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

            'opsi_id' => 'required',

            'catatan'  => 'required',




        ]);
        $validatedData['tahun'] = date('Y');
        $validatedData['pertanyaan_id'] = $request->pertanyaan_id;
        $validatedData['satker_id'] = auth()->user()->satker_id;
        $validatedData['id'] = $validatedData['tahun'] . $validatedData['satker_id'] . $validatedData['pertanyaan_id'];
        $validatedData['nilai'] = Opsi::where('id', $validatedData['opsi_id'])->first()->bobot;




        SelfAssessment::create($validatedData);
        return redirect('/lke/' . $request->lke . '/' . substr($validatedData['pertanyaan_id'], 0, 3))->with('success', 'Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function show(SelfAssessment $selfAssessment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function edit(SelfAssessment $selfAssessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SelfAssessment $selfAssessment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SelfAssessment $selfAssessment)
    {
        //
    }
}
