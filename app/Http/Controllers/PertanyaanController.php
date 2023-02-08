<?php

namespace App\Http\Controllers;

use App\Models\dokumenLKE;
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
                'link' => 'subpilar/' . $subPilar->id,
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
        $validatedData = $request->validate([
            'pertanyaan'  => 'required',
            'info'  => 'required',
            'bobot'  => 'required',
        ]);
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
        Pertanyaan::create($validatedData);

        // Opsi
        $no = 1;
        $bobot = 1;
        foreach ($request->rincian as $key => $rincian) {
            if ($rincian != null) {
                $data = new Opsi();
                $data->id = $validatedData['id'] . $no++;
                $data->rincian = $rincian;
                $data->bobot = $request->input('bobot' . $bobot++);
                $data->type = $request->type;
                $data->pertanyaan_id = $validatedData['id'];
                $data->save();
            }
        }

        // dokumen
        $no = 1;
        foreach ($request->dokumen as $key => $dokumen) {
            $data = new dokumenLKE();
            $data->id = $validatedData['id'] . $no++;
            $data->dokumen = $dokumen;
            $data->pertanyaan_id = $validatedData['id'];
            $data->save();
        }
        return redirect('subpilar/' . $subpilar)->with('success', 'New Pertanyaan Has Ben Added');
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
        return view(
            'lke.pertanyaan.edit',
            [
                'master' => 'Pertanyaan LKE ',
                'link' => 'subpilar/' . $pertanyaan->subpilar_id,
                'title' => 'Update Pertanyaan: ',
                'pertanyaan' => $pertanyaan,
                'dokumen' => dokumenLKE::where('pertanyaan_id', $pertanyaan->id)->get(),
                'subPilar' => $pertanyaan->subpilar_id,

            ]
        );
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

        $validatedData = $request->validate([
            'pertanyaan'  => 'required',
            'info'  => 'required',
            'bobot'  => 'required',
        ]);

        Pertanyaan::where('id', $pertanyaan->id)->update($validatedData);
        $subpilar = $pertanyaan->subpilar_id;

        // Opsi
        // $no = 1;
        // $bobot = 1;
        // foreach ($request->rincian as $key => $rincian) {
        //     if ($rincian != null) {
        //         $data = new Opsi();
        //         $data->id = $validatedData['id'] . $no++;
        //         $data->rincian = $rincian;
        //         $data->bobot = $request->input('bobot' . $bobot++);
        //         $data->type = $request->type;
        //         $data->pertanyaan_id = $validatedData['id'];
        //         $data->save();
        //     }
        // }

        // dokumen
        dokumenLKE::where('pertanyaan_id', $pertanyaan->id)->delete();
        $no = 1;
        foreach ($request->dokumen as $key => $dokumen) {
            $data = new dokumenLKE();
            $data->id = $pertanyaan->id . $no++;
            $data->dokumen = $dokumen;
            $data->pertanyaan_id = $pertanyaan->id;
            $data->save();
        }
        return redirect('subpilar/' . $subpilar)->with('success', ' Pertanyaan Has Ben Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pertanyaan $pertanyaan)
    {
        Pertanyaan::destroy($pertanyaan->id);
        Opsi::where('pertanyaan_id', $pertanyaan->id)->delete();
        dokumenLKE::where('pertanyaan_id', $pertanyaan->id)->delete();

        return redirect('/subpilar/' . $pertanyaan->subpilar_id)->with('success', ' Pertanyaan Has Ben Deleted');
    }
}
