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
        $pilar =  Pilar::where('subrincian_id', $request->subrincian_id)->orderBy('id', 'DESC')->first(); //mengambil data terakhir yang masuk
        $validatedData = $request->validate([
            'pilar'  => 'required',
            'min_wbk'  => 'required',
            'min_wbbm'  => 'required',
        ]);
        if ($pilar) { //cek apakah data tersebut data awal atau tidak?
            $id = substr($pilar->id, -1, 1); //ambil huruf terakhir 
            $idNum = ord($id);
            $id  = $idNum++; //tambahkan satu
            $id = chr($idNum);
        } else {
            $id = "A"; // jika ini merupakan data pertama pada database
        }
        $validatedData['subrincian_id'] = $request->subrincian_id;
        $validatedData['id'] = $validatedData['subrincian_id'] . $id;
        $validatedData['bobot'] = 0;

        Pilar::create($validatedData);

        return redirect()->back()->with('success', 'Pilar Berhasil di Tambahkan');
        // return redirect('/subrincian/' . $request->subrincian_id)->with('success', 'New Pilar Has Ben Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function show(Pilar $pilar)
    {
        $this->authorize('admin');

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
        $validatedData = $request->validate([
            'pilar'  => 'required',
            'min_wbk'  => 'required',
            'min_wbbm'  => 'required',
        ]);


        Pilar::where('id', $pilar->id)->update($validatedData);

        return redirect()->back()->with('success', 'New Pilar Has Ben Updated');
        // return redirect('/subrincian/' . $request->subrincian_id)->with('success', 'New Pilar Has Ben Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pilar  $pilar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pilar $pilar)
    {
        Pilar::destroy($pilar->id);
        return redirect()->back()->with('success', ' Pilar Has Ben Deleted');
        // return redirect('/subrincian/' . $pilar->subrincian_id)->with('success', ' Pilar Has Ben Deleted');
    }
}
