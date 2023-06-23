<?php

namespace App\Http\Controllers;

use App\Models\Pilar;
use App\Models\SubPilar;
use App\Models\Pengawasan;
use App\Models\Pertanyaan;
use App\Models\RekapHasil;
use App\Models\SubRincian;
use App\Models\Rekapitulasi;
use Illuminate\Http\Request;

use App\Models\SelfAssessment;
use App\Models\RekapPengungkit;
use App\Http\Controllers\Controller;
use App\Mail\EPEmail;
use App\Models\DeskEvaluation;
use App\Models\Rincian;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EvaluatorProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('EvalProv');
        return view('EvalProv.index', [
            'title' => 'Pengajuan ZI ' . auth()->user()->satker->nama_satker,
            'rekap' => Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->orderBy('status', 'DESC')->get(),
            'pengawasan' => Pengawasan::get(),

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */

    public function show(Rekapitulasi $evaluasi)
    {
        $this->authorize('EvalProv');

        return view('self-assessment.lke', [
            'master' => 'Evaluasi Provinsi ',
            'link' => '/prov/evaluasi',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $evaluasi,
            'pertanyaan' => Pertanyaan::count(),
            'selfAssessment' => SelfAssessment::where('rekapitulasi_id', $evaluasi->id)->count(),
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $evaluasi->id)->count('jawaban_dl'), // total soal yang terjawab oleh TPI
            'rincianPengungkit' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianHasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $evaluasi->id)->get(),
            'nilaiHasil' => RekapHasil::where('satker_id', $evaluasi->satker_id)->where('tahun', date('Y'))->get(),

        ]);
    }
    public function pertanyaan(Rekapitulasi $evaluasi, Pilar $pilar)
    {
        $this->authorize('EvalProv');
        return view('self-assessment.pertanyaan', [
            'master' => 'LKE ',
            'link' => '/prov/evaluasi/' . $evaluasi->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $evaluasi->id)->get(),
            'rekap' => $evaluasi,
        ]);
    }
    public function rekap(Rekapitulasi $rekapitulasi)
    {
        return view(
            'monitoring.lhe',
            [
                'master' => 'Rekapitulasi ',
                'link' => '/prov/evaluasi',
                'title' => 'Rekapitulasi Nilai',
                'rekap' => $rekapitulasi,
                'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),
                'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', substr($rekapitulasi->id, 0, 4))->get(),
                'rincianPengungkit' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
                'rincianHasil' => Rincian::where('id', 'H')->orderBy('bobot', 'DESC')->get(),

            ]
        );
    }
    public function catatan(Rekapitulasi $rekapitulasi)
    {
        return view('monitoring.catatan', [
            'master' => 'Rekapitulasi',
            'link' => '/prov/evaluasi',
            'title' => 'Catatan Reviu',
            'rekap' => $rekapitulasi,
            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
            'DeskEvaluation' => DeskEvaluation::all(),

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
    public function update(Request $request, Rekapitulasi $evaluasi)
    {

        $id = $request->id;

        // Rekapitulasi::where('id', $id)->update(['status' => $request->status]);
        if ($request->pengawasan_id) {
            Pengawasan::where('id', $request->pengawasan_id)->update(['status' => $request->statusPengawasan]);
        }
        if ($evaluasi->status == 4 || $evaluasi->status == 5) { //hanya bisa diakses ketika statusnya adalah penilaian tpi dan revisi tpi
            // Jika dilakukan TPI
            return redirect('/tpi/evaluasi')->with('success', 'LKE Berhasil Di Kirim');
        } else {
            $id_kabkota = $request->satker_id;
            $id_prov = substr($request->satker_id, 0, 3) . '0';
            $prov = User::where('satker_id', $id_prov)->where('level_id', 'EP')->get();
            $kabkota = User::where('satker_id', $id_kabkota)->where('level_id', 'PT')->get();
            $namakabkota =  $kabkota->first()->satker->nama_satker;
            $namaProv = $prov->first()->satker->nama_satker;
            // Jika dilakukan provinsi 
            if ($request->status == 4) {
                // Jika LKE disetujui
                $pesan = 'LKE Berhasil Di Setujui, Silahkan Cetak Surat Pengantar';
            } elseif ($request->status == 2) {
                // Jika Revisi LKE
                // Kirim Notif Gmail
                foreach ($kabkota as $value) { //kirim ke beberapa pic satker
                    $data = [
                        'title' => 'Penilaian Pendahuluan:' . $namaProv,
                        'status' => 'Perlu Perbaikan',
                        'pesan' => 'Silahkan Lakukan Perbaikan Terhadap LKE tersebut',
                        'prov' => $namaProv,
                        'kabkota' => $namakabkota,
                    ];
                    Mail::to($value->email)->send(new EPEmail($data));
                }
                $pesan = 'LKE Berhasil di Revisi, LKE akan dikembalikan kepada Satuan Kerja';
            } else {
                // Jika Tolak LKE
                foreach ($kabkota as $value) { //kirim ke beberapa evalProv
                    $data = [
                        'title' => 'Penilaian Pendahuluan  ' . $namaProv,
                        'status' => 'Tidak disetujui',
                        'pesan' => 'Satker Akan dilakukan Pembinaan',
                        'prov' => $namaProv,
                        'kabkota' => $namakabkota,
                    ];
                    Mail::to($value->email)->send(new EPEmail($data));
                }
                $pesan = 'LKE Ditolak';
            }
            return redirect('/prov/evaluasi')->with('success', $pesan);
        }
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
