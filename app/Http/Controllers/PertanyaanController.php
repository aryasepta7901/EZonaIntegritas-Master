<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\Pertanyaan;
use App\Models\SubPilar;
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
        $subpilar = $request->subpilar_id;
        $pertanyaan =  Pertanyaan::where('subpilar_id', $subpilar)->orderBy('id', 'DESC')->first(); //mengambil data terakhir yang masuk
        if ($pertanyaan) { //cek apakah data tersebut data awal atau tidak?
            $id = substr($pertanyaan->id, -1, 1); //ambil huruf terakhir 
            $idNum = ord($id);
            $id  = $idNum++; //tambahkan satu
            $id = chr($idNum);
        } else {
            $id = "A"; // jika ini merupakan data pertama pada database
        }
        $validatedData['id'] = $subpilar . $id;
        $validatedData['subpilar_id'] = $subpilar;
        // Pertanyaan::create($validatedData);

        // Opsi
        $no = 1;
        foreach ($request->rincian as $key => $rincian) {
            $data = new Opsi();
            $data->id = $validatedData['id'] . $no++;
            $data->rincian = $rincian;
            $data->bobot = 0;
            $data->type = "checkbox";
            $data->pertanyaan_id = $validatedData['id'];
            $data->save();
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
