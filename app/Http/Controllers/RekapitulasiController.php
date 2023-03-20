<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use App\Models\Pertanyaan;
use App\Models\RekapHasil;
use App\Models\SubRincian;
use App\Models\Rekapitulasi;
use Illuminate\Http\Request;
use App\Models\DeskEvaluation;
use App\Models\SelfAssessment;
use App\Models\RekapPengungkit;
use App\Http\Controllers\Controller;
use App\Models\Rincian;
use Illuminate\Support\Facades\Storage;

class RekapitulasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        //

        $request->validate(
            [
                'surat' => 'required|mimes:pdf|max:2048',

            ],
            [
                'required' => ':attribute  harus di Upload',
                'mimes' => 'Dokumen hanya boleh format :values,',
                'max' => 'Dokumen hanya boleh Berukuran :max,'
            ]
        );
        // Rekapitulasi
        if ($request->file('surat')) { //cek apakah ada dokumen yang di upload
            // Ambil File lamanya
            $rekap = Rekapitulasi::where('id', $request->id)->first();
            if ($rekap->surat_pengantar_kabkota) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->surat_pengantar_kabkota);
            }
            $customName = $request->satker_id . '-' . $request->file('surat')->getClientOriginalName();
            Rekapitulasi::updateOrCreate(
                ['id' => $request->id],
                [
                    'surat_pengantar_kabkota' =>  $request->file('surat')->storeAs('surat_pengantar/kabkota/' . date('Y') . '/', $customName),
                    'status' => 1,
                ]
            );
        }
        return redirect('satker/lke')->with('success', 'Surat Rekomendasi Berhasil di Simpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $rekapitulasi)
    {
        $this->authorize('pic');
        return view('self-assessment.rekap.rekap', [
            'master' => 'Rekapitulasi',
            'link' => 'satker/lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $rekapitulasi->predikat,
            'rekap' => $rekapitulasi,
            'pertanyaan' => Pertanyaan::count(),
            'rincianPengungkit' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianHasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'selfAssessment' => SelfAssessment::where('rekapitulasi_id', $rekapitulasi->id)->count(),
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $rekapitulasi->id)->count('jawaban_dl'),
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),
            'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', date('Y'))->get(),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),


        ]);
    }
    public function rekap2(Rekapitulasi $rekapitulasi)
    {
        $this->authorize('pic');
        return view('self-assessment.rekap.rekap2', [
            'master' => 'Rekapitulasi',
            'link' => 'satker/lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $rekapitulasi->predikat,
            'rekap' => $rekapitulasi,
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),


        ]);
    }
    public function rekap3(Rekapitulasi $rekapitulasi)
    {
        $this->authorize('pic');
        return view('self-assessment.rekap.test', [
            'master' => 'Rekapitulasi',
            'link' => 'satker/lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $rekapitulasi->predikat,
            'rekap' => $rekapitulasi,
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),


        ]);
    }
    // View Surat Persetujuan BPS Kab/Kota
    public function surat(Rekapitulasi $rekapitulasi)
    {

        return view('self-assessment.surat', [
            'master' => 'lke',
            'link' => 'satker/lke/' . $rekapitulasi->id,
            'title' => 'Surat Pengantar BPS Kabupaten/Kota',
            'rekap' => $rekapitulasi,
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),
            'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', date('Y'))->sum('nilai'),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekapitulasi $rekapitulasi)
    {
    }
}
