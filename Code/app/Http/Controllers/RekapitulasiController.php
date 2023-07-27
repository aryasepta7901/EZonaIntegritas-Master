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
use App\Mail\Email;
use App\Mail\SAEmail;
use App\Models\LHE;
use App\Models\Rincian;
use App\Models\Satker;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

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
        $request->validate(
            [
                'surat' => 'required|mimes:pdf|max:2048',

            ],
            [
                'required' => ':attribute  harus di Upload',
                'mimes' => 'Dokumen hanya boleh format :values,',
                'max' => 'Dokumen hanya boleh Berukuran 2MB,'
            ]
        );
        // Kirim Surat (Gmail)
        $id_kabkota = $request->satker_id;
        $id_prov = substr($request->satker_id, 0, 3) . '0';
        $prov = User::where('satker_id', $id_prov)->where('level_id', 'EP')->get();
        $kabkota = User::where('satker_id', $id_kabkota)->where('level_id', 'PT')->first();
        $namakabkota =  $kabkota->satker->nama_satker;
        // Kirim Notif Gmail
        foreach ($prov as $value) { //kirim ke beberapa evalProv
            $data = [
                'title' => 'Hasil Penilaian Mandiri ' . $namakabkota,
                'prov' => $value->satker->nama_satker,
                'kabkota' => $namakabkota,
                'nilai' => $request->nilai,
            ];
            Mail::to($value->email)->send(new SAEmail($data));
        }
        // Rekapitulasi
        if ($request->file('surat')) { //cek apakah ada dokumen yang di upload
            // Ambil File lamanya

            $rekap = Rekapitulasi::where('id', $request->id)->first();
            if ($rekap->LHE->surat_pengantar_kabkota) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->LHE->surat_pengantar_kabkota);
            }
            $customName = $request->satker_id . '-' . $request->file('surat')->getClientOriginalName();
            Rekapitulasi::updateOrCreate(
                ['id' => $request->id],
                [
                    'status' => 1,
                ]
            );
            LHE::updateOrCreate(
                ['rekapitulasi_id' => $request->id],
                [
                    'surat_pengantar_kabkota' =>  $request->file('surat')->storeAs('surat_pengantar/kabkota/' . date('Y') . '/', $customName),
                ]
            );
        }
        return redirect('satker/lke')->with('success', 'Surat Rekomendasi Berhasil di Simpan');
    }
    // View Surat Persetujuan BPS Kab/Kota
    public function show(Rekapitulasi $rekapitulasi)
    {

        return view('self-assessment.surat', [
            'master' => 'LKE',
            'link' => '/satker/lke/' . $rekapitulasi->id,
            'title' => 'Surat Pengantar BPS Kabupaten/Kota',
            'rekap' => $rekapitulasi,
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id)->sum('nilai_sa'),
            // 'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', date('Y'))->sum('nilai'),
            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function rekapFull(Rekapitulasi $rekapitulasi)
    {
        $this->authorize('pic');
        return view('self-assessment.rekap.rekap', [
            'master' => 'Rekapitulasi',
            'link' => '/satker/lke',
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
            'link' => '/satker/lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $rekapitulasi->predikat,
            'rekap' => $rekapitulasi,
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),


        ]);
    }
    public function rekap3(Rekapitulasi $rekapitulasi)
    {
        $this->authorize('pic');
        return view('self-assessment.rekap.rekap3', [
            'master' => 'Rekapitulasi',
            'link' => '/satker/lke',
            'title' => 'Lembar Kerja Evaluasi: ' . $rekapitulasi->predikat,
            'rekap' => $rekapitulasi,
            'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),

            'rincian' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),


        ]);
    }
    public function rekap(Rekapitulasi $rekapitulasi)
    {
        return view(
            'monitoring.lhe',
            [
                'master' => 'Rekapitulasi ',
                'link' => '/satker/lke',
                'title' => 'Rekapitulasi Nilai',
                'rekap' => $rekapitulasi,
                'nilaiPengungkit' => RekapPengungkit::where('rekapitulasi_id', $rekapitulasi->id),
                'nilaiHasil' => RekapHasil::where('satker_id', $rekapitulasi->satker_id)->where('tahun', $rekapitulasi->tahun)->get(),
                'rincianPengungkit' => Rincian::where('id', 'P')->orderBy('bobot', 'DESC')->get(),
                'rincianHasil' => Rincian::where('id', 'H')->orderBy('bobot', 'DESC')->get(),

            ]
        );
    }
    public function catatan(Rekapitulasi $rekapitulasi)
    {
        return view('monitoring.catatan', [
            'master' => 'Rekapitulasi',
            'link' => '/satker/lke',
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
    public function cetak(Request $request)
    {
        $request->validate(
            [
                'no_surat' => 'required',
            ],
            [
                'required' => ':attribute  harus di Upload',
            ]
        );
        // Script PhpWord
        // Creating the new document...
        $phpWord = new TemplateProcessor('template_kab.docx');
        // Edit String
        // ambil data provinsi
        $prov = substr($request->satker_id, 0, 3) . '0';
        $nama_prov = Satker::where('id', $prov)->first()->nama_satker;
        $bps_prov = $nama_prov;
        $phpWord->setValues([
            'y' => date('Y'),
            'no_surat' => $request->no_surat,
            'tanggal' => Carbon::parse(date(''))->isoFormat('DD MMMM YYYY', 'id'),
            'total_sa' => $request->nilaisa,
            'satker' => substr($request->satker, 3),
            'bps_prov' => $bps_prov,

        ]);
        // Table Pemenuhan
        $pilar = Pilar::where('subrincian_id', 'PP')->get(); //ambil data Pengungkit bagian pemenuhan
        $dataTableP = [];
        $i = 1;
        $nilaiP_sa = 0;
        foreach ($pilar as $p) {
            // Ambil Nilai Pengungkit
            $nilai_sa = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_sa');
            $nilaiP_sa += $nilai_sa;
            $dataTableP[] = [
                'no' => $i++,
                'hasil_sa' =>     round($nilai_sa, 2),
                'pilar' => $p->pilar,
                'bb' => number_format($p->bobot, 2),
            ];
        }
        $phpWord->setValues([
            'nilaiP_sa' => round($nilaiP_sa, 2),
        ]);
        $phpWord->cloneRowAndSetValues('hasil_sa', $dataTableP);

        // Table Reform
        $pilar = Pilar::where('subrincian_id', 'PR')->get(); //ambil data Pengungkit bagian reform
        $dataTableR = [];
        $i = 1;
        $nilaiR_sa = 0;
        foreach ($pilar as $p) {
            // Ambil Nilai Pengungkit
            $nilai_sa = $p->RekapPengungkit->where('rekapitulasi_id', $request->id)->sum('nilai_sa');
            $nilaiR_sa += $nilai_sa;
            $dataTableR[] = [
                'no' => $i++,
                'hasil_sa' =>  round($nilai_sa, 2),
                'pilar' => $p->pilar,
                'bb' => number_format($p->bobot, 2),
            ];
        }
        $phpWord->setValues([
            'nilaiR_sa' => round($nilaiR_sa, 2),
        ]);
        // Populate the table in the template
        $phpWord->cloneRowAndSetValues('hasil_sa', $dataTableR);
        // Simpan hasil proses ke file Word sementara
        $fileName = 'pengantar_' . $request->satker . '.docx';
        $phpWord->saveAs($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
