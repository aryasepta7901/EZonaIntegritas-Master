<?php

namespace App\Http\Controllers;

use App\Models\Pengawasan;
use App\Models\Pilar;
use App\Models\Rekapitulasi;
use App\Models\RekapPengungkit;
use App\Models\TPI;
use App\Models\User;
use App\Models\Satker;
use PhpOffice\PhpWord\TemplateProcessor;

use Illuminate\Http\Request;

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
        } else {
            $nama_prov = '';
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
            'nilai' =>  round($request->nilai, 2),
            'at' => $request->at,
            'id_at' => $request->id_at,
            'kt' => $request->kt,
            'id_kt' => $request->id_kt,
            'dalnis' => $request->dalnis,
            'id_dl' => $request->id_dl,
            'prov' => $nama_prov,
            'nama_daerah' => $nama_daerah,
        ]);

        // Table Pemenuhan
        $pilar = Pilar::where('subrincian_id', 'PP')->get(); //ambil data Pengungkit bagian pemenuhan
        $dataTableP = [];
        $i = 0;
        foreach ($pilar as $p) {
            // Ambil Nilai Pengungkit
            $nilai_sa = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_sa');
            $nilai_dl = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_dl');
            $dataTableP[] = [
                'no' => $i++,
                'hasil_sa' =>     round($nilai_sa, 2),
                'hasil_dl' => round($nilai_dl, 2),
                'pilar' => $p->pilar,
                'bb' => number_format($p->bobot, 2),
            ];
        }
        $phpWord->cloneRowAndSetValues('hasil_dl', $dataTableP);

        // Table Reform
        $pilar = Pilar::where('subrincian_id', 'PR')->get(); //ambil data Pengungkit bagian reform
        $dataTableR = [];
        $i = 1;
        foreach ($pilar as $p) {
            // Ambil Nilai Pengungkit
            $nilai_sa = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_sa');
            $nilai_dl = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_dl');
            $dataTableR[] = [
                'no' => $i++,
                'hasil_sa' =>  round($nilai_sa, 2),
                'hasil_dl' => round($nilai_dl, 2),
                'pilar' => $p->pilar,
                'bb' => number_format($p->bobot, 2),
            ];
        }
        // Populate the table in the template
        $phpWord->cloneRowAndSetValues('hasil_dl', $dataTableR);

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
            'link' => 'tpi/evaluasi/' . $lhe->id,
            'rekap' => $rekap,
            'anggota' => User::where('id', $pengawasan->anggota_id)->first(),
            'ketua' => User::where('id', $tpi->ketua_tim)->first(),
            'dalnis' => User::where('id', $tpi->dalnis)->first(),
            'nilai' => RekapPengungkit::where('rekapitulasi_id', $lhe->id),

            'title' => 'Lembar Hasil Evaluasi',

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
