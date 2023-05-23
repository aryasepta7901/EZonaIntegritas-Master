<?php

namespace App\Http\Controllers;

use App\Models\dokumenLKE;
use App\Models\Opsi;
use App\Models\Rincian;
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
     *@param  \App\Models\SubPilar  $pertanyaan

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
        return redirect('pertanyaan')->with('success', 'Pertanyaan Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function show(SubPilar $pertanyaan)
    {
        $this->authorize('admin');

        return view(
            'lke.pertanyaan.create',
            [
                'master' => 'Pertanyaan LKE ',
                'link' => '/pertanyaan',
                'title' => 'Create Pertanyaan: ',
                'subPilar' => $pertanyaan,


            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pertanyaan  $pertanyaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pertanyaan $pertanyaan)
    {
        $this->authorize('admin');

        return view(
            'lke.pertanyaan.edit',
            [
                'master' => 'Pertanyaan LKE ',
                'link' => '/pertanyaan',
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
        return redirect('pertanyaan')->with('success', ' Pertanyaan Berhasil di Ubah');
        // return redirect('subpilar/' . $subpilar)->with('success', ' Pertanyaan Berhasil di Ubah');
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

        return redirect('pertanyaan')->with('success', ' Pertanyaan Berhasil di Hapus');
    }
}
