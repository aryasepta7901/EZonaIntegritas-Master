<?php

namespace App\Http\Controllers;

use App\Mail\PTEmailDL;
use App\Mail\SAEmail;
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
use App\Models\LHE;
use App\Models\Pengawasan;
use App\Models\Satker;
use App\Models\TPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        return view('self-assessment.index', [
            'title' => 'Dashboard Pengajuan Zona Integritas',
            'persyaratan' => Persyaratan::where('satker_id', auth()->user()->satker_id)->where('tahun', date('Y'))->first(),
            'rekap' => Rekapitulasi::where('satker_id', auth()->user()->satker_id)->get(),
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
        $data = [
            'predikat' => $request->predikat,
            'tahun' => date('Y'),
            'satker_id' => $request->satker_id,
        ];
        $uuid = Str::uuid()->toString();
        $uuidWithoutNumbersAndDashes = preg_replace('/[-]/', '', $uuid);
        $uuidWithoutRepeatedLetters = preg_replace('/(\w)\1+/', '', $uuidWithoutNumbersAndDashes);

        $data['id'] = $uuidWithoutRepeatedLetters . $data['satker_id'];
        Rekapitulasi::create($data);

        $dataLHE = [
            'rekapitulasi_id' => $data['id'],
        ];
        LHE::create($dataLHE);

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
    public function update(Request $request, Rekapitulasi $lke)
    {
        // Kirim LKE
        // Function ini digunakan oleh Provinsi dan kab/kota(khusus kab/kota hanya ketika tindak lanjut dari TPI) 
        if ($lke->status == 0 || $lke->status == 2) {
            // Provinsi
            $id_kabkota = $request->satker_id;
            $id_prov = substr($request->satker_id, 0, 3) . '0';
            $prov = User::where('satker_id', $id_prov)->where('level_id', 'EP')->get();
            $kabkota = User::where('satker_id', $id_kabkota)->where('level_id', 'PT')->first();
            $namakabkota =  $kabkota->satker->nama_satker;
            // Kirim Notif Gmail
            foreach ($prov as $value) { //kirim ke beberapa evalProv
                $email[] = $value->email;
            }
            $data = [
                'title' => 'Hasil Penilaian Mandiri ' . $namakabkota,
                'prov' => $value->satker->nama_satker,
                'kabkota' => $namakabkota,
                'nilai' => $request->nilai,
            ];
            Mail::to($email)->send(new SAEmail($data));
        }
        if ($lke->status == '5') {
            // Satker pada tahap 5(tindak lanjut dari TPI)
            $id_satker = $lke->satker_id;
            $namaSatker = Satker::where('id', $id_satker)->first()->nama_satker;
            $pengawasan = Pengawasan::where('satker_id', $id_satker)->first();
            $anggota = $pengawasan->anggota_id;
            $id_tpi = $pengawasan->tpi_id;

            $tpi = TPI::where('id', $id_tpi)->first();
            $dalnis = $tpi->dalnis;
            $ketua = $tpi->ketua_tim;
            $tpi_array = [$dalnis, $ketua, $anggota];

            foreach ($tpi_array as $tpi) {
                $email[] = User::where('id', $tpi)->first()->email;
            }
            $data = [
                'title' => 'Hasil Revisi Penilaian Mandiri ' . $namaSatker,
                'namaSatker' => $namaSatker,
                'nilai' => $request->nilai,
            ];
            Mail::to($email)->send(new PTEmailDL($data));
        }

        Rekapitulasi::where('id', $lke->id)->update(['status' => $request->status]);

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
