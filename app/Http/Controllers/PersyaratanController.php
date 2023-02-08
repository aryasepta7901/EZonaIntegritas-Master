<?php

namespace App\Http\Controllers;

use App\Models\persyaratan;
use App\Models\Satker;
use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view(
            'persyaratan.index',
            [
                'title' => 'Mengelola Persyaratan WBK/WBBM',
                'persyaratan' => Persyaratan::all(),
                'satker' => Satker::doesntHave('persyaratan')->get(),

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
        $validatedData = $request->validate([
            'satker_id' => 'required',
        ]);
        $validatedData['tahun'] = date('Y');

        $validatedData['id'] = $validatedData['satker_id'] . $validatedData['tahun'];

        if ($request->wbk == null) {
            $validatedData['wbk'] = 0;
        } else {
            $validatedData['wbk'] = $request->wbk;
        }
        if ($request->wbbm == null) {
            $validatedData['wbbm'] = 0;
        } else {
            $validatedData['wbbm'] = $request->wbbm;
        }

        persyaratan::create($validatedData);

        return redirect('/persyaratan')->with('success', 'New Persyaratan Has Ben Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function show(persyaratan $persyaratan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function edit(persyaratan $persyaratan)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, persyaratan $persyaratan)
    {
        $validatedData = $request->validate([
            'satker_id' => 'required',
        ]);
        $validatedData['tahun'] = date('Y');

        $validatedData['id'] = $validatedData['satker_id'] . $validatedData['tahun'];

        if ($request->wbk == null) {
            $validatedData['wbk'] = 0;
        } else {
            $validatedData['wbk'] = $request->wbk;
        }
        if ($request->wbbm == null) {
            $validatedData['wbbm'] = 0;
        } else {
            $validatedData['wbbm'] = $request->wbbm;
        }

        persyaratan::where('id', $persyaratan->id)->update($validatedData);

        return redirect('/persyaratan')->with('success', 'New Persyaratan Has Ben Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\persyaratan  $persyaratan
     * @return \Illuminate\Http\Response
     */
    public function destroy(persyaratan $persyaratan)
    {
        persyaratan::destroy($persyaratan->id);

        return redirect('/persyaratan')->with('success', 'Persyaratan Has Ben Deleted');
    }
}
