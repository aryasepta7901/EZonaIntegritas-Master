<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\Pertanyaan;
use App\Models\SubPilar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PertanyaanController extends Controller
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
        $subPilar = Session::get('subPilar');
        return view(
            'lke.pertanyaan.create',
            [
                'master' => 'Pertanyaan LKE ',
                'link' => 'subpilar/' . substr($subPilar->id, 0, 4),
                'title' => 'Create Pertanyaan: ',
                'subPilar' => $subPilar,

            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'pertanyaan'  => 'required',
        //     'info'  => 'required',
        //     'bobot'  => 'required',
        // ]);



        // Pertanyaan::create($validatedData);
        for ($i = 1; $i < 2; $i++) {
            foreach ($request->opsi as $key => $opsi) {
                $data = new Opsi();
                $data->id = $opsi;
                $data->rincian = $opsi;
                $data->bobot = 0;
                $data->type = "Cek";
                $data->pertanyaan_id = "PP";
                $data->save();
            }
        }
        return redirect('pertanyaan/create')->with('success', 'New Rincian Has Ben Added');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pertanyaan $pertanyaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pertanyaan $pertanyaan)
    {
        //
    }
}
