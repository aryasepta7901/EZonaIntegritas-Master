<?php

namespace App\Http\Controllers;

use App\Models\Rincian;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

class PertanyaanController extends Controller
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
            'lke.pertanyaan',
            [
                'title' => 'Mengelola Pertanyaan',
                'rincian' => Rincian::orderBy('id', 'DESC')->get(),
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function show(Pertanyaan $pertanyaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pertanyaan $pertanyaan)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @param  \App\Models\Rincian  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rincian $rincian)
    {
        // if ($request->submit_rincian) {
        //     $validatedData = $request->validate([
        //         'rincian'  => 'required',
        //     ]);

        //     Rincian::where('id', $rincian->id)->update($validatedData);

        //     return redirect('/rincian')->with('success', 'New Rincian Has Ben Updated');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pertanyaan $pertanyaan)
    {
    }
}
