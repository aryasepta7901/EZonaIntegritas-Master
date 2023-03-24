<?php

namespace App\Http\Controllers;

use App\Models\DeskEvaluation;
use App\Models\Persyaratan;
use App\Models\Pertanyaan;
use App\Models\SelfAssessment;
use App\Models\Pilar;
use App\Models\Rekapitulasi;
use App\Models\RekapPengungkit;
use App\Models\SubPilar;
use App\Models\SubRincian;
use App\Models\RekapHasil;
use Illuminate\Http\Request;

class LKEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('pic');

        return view('self-assessment.rekap', [
            'title' => 'Rekapitulasi Lembar Kerja Evaluasi',
            'persyaratan' => Persyaratan::where('satker_id', auth()->user()->satker_id)->where('tahun', date('Y'))->first(),
            'rekap' => Rekapitulasi::where('satker_id', auth()->user()->satker_id)->get(),
        ]);
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
        $data = [
            'predikat' => $request->predikat,
            'tahun' => date('Y'),
            'satker_id' => $request->satker_id,
        ];
        $data['id'] = $data['tahun'] . $data['predikat'] . $data['satker_id'];

        Rekapitulasi::create($data);

        return redirect()->back()->with('success', 'Pengajuan Berhasil di Buat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $lke)
    {
        $this->authorize('pic');
        return view('self-assessment.lke', [
            'master' => 'Rekapitulasi',
            'link' => 'satker/lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $lke->predikat,
            'rekap' => $lke,
            'pertanyaan' => Pertanyaan::count(), //hitung jumlah soal
            'selfAssessment' => SelfAssessment::where('rekapitulasi_id', $lke->id)->count(), //total soal yang terjawab oleh PIC satker
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $lke->id)->count('jawaban_dl'), // total soal yang terjawab oleh TPI
            'rincianPengungkit' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianHasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $lke->id)->get(),
            'nilaiHasil' => RekapHasil::where('satker_id', $lke->satker_id)->where('tahun', date('Y'))->get(),


        ]);
    }

    public function pertanyaan(Rekapitulasi $lke, Pilar $pilar)
    {
        $this->authorize('pic');

        return view('self-assessment.pertanyaan', [
            'master' => 'LKE ',
            'link' => '/satker/lke/' . $lke->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $lke->id)->get(),
            'rekap' => $lke,


        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rekapitulasi $rekapitulasi)
    {
        // Kirim LKE
        $id = $request->id;
        Rekapitulasi::where('id', $id)->update(['status' => $request->status]);

        return redirect('/satker/lke')->with('success', 'LKE Berhasil Di Kirim');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekapitulasi $rekapitulasi)
    {
        //
    }
}
