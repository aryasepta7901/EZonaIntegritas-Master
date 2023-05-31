<?php

namespace App\Http\Controllers;

use App\Imports\LHEImport;
use App\Models\Pengawasan;
use App\Models\Pilar;
use App\Models\Rekapitulasi;
use App\Models\RekapPengungkit;
use App\Models\TPI;
use App\Models\User;
use App\Models\Satker;
use App\Models\SubPilar;
use App\Models\Pertanyaan;
use PhpOffice\PhpWord\TemplateProcessor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LheController extends Controller
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
                'max' => 'Dokumen hanya boleh Berukuran maksimal 2MB'
            ]
        );
        if ($request->file('surat')) { //cek apakah ada dokumen yang di upload
            // Ambil File lamanya
            $rekap = Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->where('status', 4)->first();
            if ($rekap) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->surat_pengantar_prov);
            }
            $customName = $request->satker_id . '-' . $request->file('surat')->getClientOriginalName();

            foreach ($request->id as $key => $id) {

                Rekapitulasi::updateOrCreate(
                    ['id' => $id],
                    [
                        'surat_pengantar_prov' =>  $request->file('surat')->storeAs('surat_pengantar/prov/' . date('Y') . '/', $customName),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Surat Pengantar Berhasil di Simpan');
    }
    public function cetak(Request $request)
    {
        $satker = $request->satker;
        $id = $request->id;

        // Script PhpWord
        // Creating the new document...
        $phpWord = new TemplateProcessor('template_lhe.docx');


        if (substr($request->satker_id, -1) != 0) //cek apakah levelnya adalah bps provinsi
        // Jika levelnya bps kab/kota maka
        {
            // ambil data provinsi
            $prov = substr($request->satker_id, 0, 3) . '0';
            $nama_prov = Satker::where('id', $prov)->first()->nama_satker;
            $tembusanDaerah = $nama_prov;
        } else {
            // jika levelnya bps provinsi
            $nama_prov = '';
            $tembusanDaerah = $satker;
        }
        // Pecah teks menjadi array kata
        $words = explode(" ", $request->satker);
        // Mengambil nama daerah
        $nama_daerah = implode(" ", array_slice($words, 2, 5));



        // Edit String
        $phpWord->setValues([
            'y' => date('Y'),
            'tanggal' => date('d F Y'),
            'satker' => $satker,
            'total_sa' =>  round($request->nilaisa, 2),
            'total_dl' =>  round($request->nilaidl, 2),
            'at' => $request->at,
            'id_at' => $request->id_at,
            'kt' => $request->kt,
            'id_kt' => $request->id_kt,
            'dalnis' => $request->dalnis,
            'id_dl' => $request->id_dl,
            'prov' => $nama_prov,
            'nama_daerah' => $nama_daerah,
            'tembusanDaerah' => $tembusanDaerah,
        ]);

        // Table Pemenuhan
        $pilar = Pilar::where('subrincian_id', 'PP')->get(); //ambil data Pengungkit bagian pemenuhan
        $dataTableP = [];
        $i = 1;
        $nilaiP_sa = 0;
        $nilaiP_dl = 0;
        foreach ($pilar as $p) {
            // Ambil Nilai Pengungkit
            $nilai_sa = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_sa');
            $nilai_dl = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_dl');
            $nilaiP_sa += $nilai_sa;
            $nilaiP_dl += $nilai_dl;
            $dataTableP[] = [
                'no' => $i++,
                'hasil_sa' =>     round($nilai_sa, 2),
                'hasil_dl' => round($nilai_dl, 2),
                'pilar' => $p->pilar,
                'bb' => number_format($p->bobot, 2),
            ];
        }
        $phpWord->setValues([
            'nilaiP_sa' => round($nilaiP_sa, 2),
            'nilaiP_dl' => round($nilaiP_dl, 2),
        ]);
        $phpWord->cloneRowAndSetValues('hasil_dl', $dataTableP);

        // Table Reform
        $pilar = Pilar::where('subrincian_id', 'PR')->get(); //ambil data Pengungkit bagian reform
        $dataTableR = [];
        $i = 1;
        $nilaiR_sa = 0;
        $nilaiR_dl = 0;
        foreach ($pilar as $p) {
            // Ambil Nilai Pengungkit
            $nilai_sa = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_sa');
            $nilai_dl = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_dl');
            $nilaiR_sa += $nilai_sa;
            $nilaiR_dl += $nilai_dl;
            $dataTableR[] = [
                'no' => $i++,
                'hasil_sa' =>  round($nilai_sa, 2),
                'hasil_dl' => round($nilai_dl, 2),
                'pilar' => $p->pilar,
                'bb' => number_format($p->bobot, 2),
            ];
        }
        $phpWord->setValues([
            'nilaiR_sa' => round($nilaiR_sa, 2),
            'nilaiR_dl' => round($nilaiR_dl, 2),
        ]);
        // Populate the table in the template
        $phpWord->cloneRowAndSetValues('hasil_dl', $dataTableR);


        $subPilar = SubPilar::where('pilar_id', 'PPA')->get();
        $data = [];
        $dataPertanyaan = [];

        foreach ($subPilar as $value) {
            $data[] = [
                'subPilar' => $value->subPilar,
                // 'pertanyaan' => Pertanyaan::where('subpilar_id', $value->id)->first()->pertanyaan,
            ];
            foreach ($value->pertanyaan as $pt) {
                $dataPertanyaan[] = [
                    'pertanyaan' => $pt->pertanyaan,
                ];
            }
        }
        $phpWord->cloneRowAndSetValues('subPilar', $data);
        $phpWord->cloneRowAndSetValues('pertanyaan', $dataPertanyaan);


        // Simpan hasil proses ke file Word sementara
        $phpWord->saveAs($id . '.docx');
        return response()->download($id . '.docx')->deleteFileAfterSend(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $lhe)
    {

        $this->authorize('TPI');
        $rekap = Rekapitulasi::where('id', $lhe->id)->first(); //data rekap

        $pengawasan = Pengawasan::where('satker_id', $rekap->satker_id)->first(); //data pengawasan
        $tpi = TPI::where('id', $pengawasan->tpi_id)->first();
        return view('tpi.lhe', [
            'master' => 'LKE',
            'link' => '/tpi/evaluasi/' . $lhe->id,
            'rekap' => $rekap,
            'anggota' => User::where('id', $pengawasan->anggota_id)->first(),
            'ketua' => User::where('id', $tpi->ketua_tim)->first(),
            'dalnis' => User::where('id', $tpi->dalnis)->first(),
            'nilai' => RekapPengungkit::where('rekapitulasi_id', $lhe->id),

            'title' => 'Laporan Hasil Evaluasi',

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
        //
    }
}
