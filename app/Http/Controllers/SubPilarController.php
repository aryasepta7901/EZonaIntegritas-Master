<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Pilar;
use App\Models\Rincian;
use App\Models\SubPilar;
use App\Models\SubRincian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubPilarController extends Controller
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
        $subpilar =  SubPilar::where('pilar_id', $request->pilar_id)->orderBy('id', 'DESC')->first(); //mengambil data terakhir yang masuk
        $validatedData = $request->validate([
            'subPilar'  => 'required',
            'bobot'  => 'required',
        ]);
        if ($subpilar) {
            $id = substr($subpilar->id, -1, 1); //ambil angka 
            $id += 1; //tambahkan satu
        } else {
            $id = 1;
        }
        $validatedData['pilar_id'] = $request->pilar_id;
        $validatedData['id'] = $validatedData['pilar_id'] . $id;


        SubPilar::create($validatedData);

        $bobot = $validatedData['bobot'];

        // Pilar
        $bobotPilar = Pilar::where('id', $request->pilar_id)->first()->bobot;
        Pilar::where('id', $request->pilar_id)->update(['bobot' => $bobot + $bobotPilar]);

        // SubRincian
        $subrincian_id = substr($request->pilar_id, 0, 2);
        $bobotSubRincian = SubRincian::where('id', $subrincian_id)->first()->bobot;
        SubRincian::where('id', $subrincian_id)->update(['bobot' => $bobot + $bobotSubRincian]);

        // Rincian
        $rincian_id = substr($request->pilar_id, 0, 1);
        $bobotRincian = Rincian::where('id', $rincian_id)->first()->bobot;
        Rincian::where('id', $rincian_id)->update(['bobot' => $bobot + $bobotRincian]);


        return redirect('/pilar/' . $request->pilar_id)->with('success', 'New Sub Pilar Has Ben Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subPilar  $subPilar
     * @return \Illuminate\Http\Response
     */
    public function show(subPilar $subpilar)
    {
        Session::put('subPilar', $subpilar);

        return view(
            'lke.pertanyaan.index',
            [
                'master' => 'Pertanyaan LKE ',
                'link' => 'pilar/' . substr($subpilar->id, 0, 3),
                'title' => 'Pertanyaan LKE: ' . $subpilar->subPilar,
                'subPilar' => $subpilar,
                'pertanyaan' => Pertanyaan::where('subpilar_id', $subpilar->id)->get(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subPilar  $subPilar
     * @return \Illuminate\Http\Response
     */
    public function edit(subPilar $subPilar)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subPilar  $subPilar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subPilar $subpilar)
    {
        $validatedData = $request->validate([
            'subPilar'  => 'required',
            'bobot'  => 'required',
        ]);

        SubPilar::where('id', $subpilar->id)->update($validatedData);

        $bobot = $validatedData['bobot'];


        if ($subpilar->bobot != $bobot) //cek apakah bobot lama sama dengan bobot baru
        {
            // Pilar
            $bobot -= $subpilar->bobot; //data baru dikurang data lama
            $bobotPilar = Pilar::where('id', $request->pilar_id)->first()->bobot;
            Pilar::where('id', $request->pilar_id)->update(['bobot' => $bobot + $bobotPilar]);
            // SubRincian
            $subrincian_id = substr($request->pilar_id, 0, 2);
            $bobotSubRincian = SubRincian::where('id', $subrincian_id)->first()->bobot;
            SubRincian::where('id', $subrincian_id)->update(['bobot' => $bobot + $bobotSubRincian]);

            // Rincian
            $rincian_id = substr($request->pilar_id, 0, 1);
            $bobotRincian = Rincian::where('id', $rincian_id)->first()->bobot;
            Rincian::where('id', $rincian_id)->update(['bobot' => $bobot + $bobotRincian]);
        }



        return redirect('/pilar/' . $request->pilar_id)->with('success', 'New Sub Pilar Has Ben Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subPilar  $subPilar
     * @return \Illuminate\Http\Response
     */
    public function destroy(subPilar $subpilar)
    {
        //SubPilar
        SubPilar::destroy($subpilar->id);
        $bobot = $subpilar->bobot;
        // Pilar
        $bobotPilar = Pilar::where('id', $subpilar->pilar_id)->first()->bobot;
        Pilar::where('id', $subpilar->pilar_id)->update(['bobot' => $bobotPilar - $bobot]);

        // SubRincian
        $subrincian_id = substr($subpilar->pilar_id, 0, 2);
        $bobotSubRincian = SubRincian::where('id', $subrincian_id)->first()->bobot;
        SubRincian::where('id', $subrincian_id)->update(['bobot' =>   $bobotSubRincian - $bobot]);

        // Rincian
        $rincian_id = substr($subpilar->pilar_id, 0, 1);
        $bobotRincian = Rincian::where('id', $rincian_id)->first()->bobot;
        Rincian::where('id', $rincian_id)->update(['bobot' => $bobotRincian - $bobot]);

        return redirect('/pilar/' . $subpilar->pilar_id)->with('success', 'New Sub Pilar Has Ben Deleted');
    }
}
