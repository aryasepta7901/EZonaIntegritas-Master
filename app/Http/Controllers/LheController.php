<?php

namespace App\Http\Controllers;

use App\Imports\LHEImport;
use App\Mail\DLEmailPT;
use App\Models\Pengawasan;
use App\Models\Pilar;
use App\Models\Rekapitulasi;
use App\Models\RekapPengungkit;
use App\Models\TPI;
use App\Models\User;
use App\Models\Satker;
use App\Models\SubPilar;
use App\Models\Pertanyaan;
use App\Models\LHE;
use PhpOffice\PhpWord\TemplateProcessor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PHPUnit\TextUI\XmlConfiguration\Php;

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
    {  // Kirim Notif Gmail
        $id_satker = $request->satker_id;
        $satker = Satker::where('id', $id_satker)->first();
        $id_satker = $satker->id;
        $user = User::where('satker_id', $id_satker)->get();
        foreach ($user as $item) {
            $email[] = $item->email;
        }
        $nama_satker = $satker->nama_satker;
        $data = [
            'title' => 'Hasil Penilaian Evaluasi:' . $nama_satker . '[Tahap ' . $request->tahap_pengawasan . ']',
            'nama_satker' => $nama_satker,
        ];

        if ($request->submit_1) {  //lhe_1
            $request->validate(
                [
                    'lhe' => 'required|mimes:pdf|max:2048',

                ],
                [
                    'required' => ':attribute  harus di Upload',
                    'mimes' => 'Dokumen hanya boleh format :values,',
                    'max' => 'Dokumen hanya boleh Berukuran maksimal 2MB'
                ]
            );
            // Kirim Gmail
            $data['status'] = 'Perlu Perbaikan';
            $data['pesan'] = 'silahkan lakukan perbaikan terhadap LKE tersebut';
            Mail::to($email)->send(new DLEmailPT($data));
            // Ambil File lamanya
            $rekap = Rekapitulasi::where('id', $request->id)->first();
            if ($rekap->LHE->LHE_1) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->LHE->LHE_1);
            }
            $customName = $request->file('lhe')->getClientOriginalName();
            Rekapitulasi::updateOrCreate(
                ['id' => $request->id],
                [
                    'status' => 5,
                ]
            );
            Pengawasan::updateOrCreate(
                ['id' => $request->anggota_id . $request->satker_id],
                [
                    'tahap' => 2,
                    'status' => 0,
                ]
            );
            LHE::updateOrCreate(
                ['rekapitulasi_id' => $request->id],
                [
                    'LHE_1' =>  $request->file('lhe')->storeAs('LHE/' . date('Y') . '/' . 'Tahap1/', $customName),
                ]
            );
            return redirect('/tpi/evaluasi')->with('success', 'LHE Berhasil di Simpan');
        }
        if ($request->submit_2) {  //lhe_1
            // Ambil File lamanya
            $request->validate(
                [
                    'persetujuan' => 'required',
                    'lhe' => 'required|mimes:pdf|max:2048',

                ],
                [
                    'lhe.required' => ':attribute  harus di Upload',
                    'persetujuan.required' => ':attribute  wajib diisi',
                    'mimes' => 'Dokumen hanya boleh format :values,',
                    'max' => 'Dokumen hanya boleh Berukuran maksimal 2MB'

                ]
            );
            // Kirim Gmail
            if ($request->persetujuan == '6') {
                // Jika disetujui
                $data['status'] = 'Disetujui';
                $data['pesan'] = 'satuan kerja akan dipersiapkan untuk pengajuan kepada Kementrian PanRB';
            } else {
                // Jika Ditolak
                $data['status'] = 'Ditolak';
                $data['pesan'] = 'satuan kerja akan dilakukan pembinaan';
            }
            Mail::to($email)->send(new DLEmailPT($data));
            $rekap = Rekapitulasi::where('id', $request->id)->first();
            if ($rekap->LHE->LHE_2) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->LHE->LHE_2);
            }
            $customName = $request->file('lhe')->getClientOriginalName();
            Rekapitulasi::updateOrCreate(
                ['id' => $request->id],
                [
                    'status' => $request->persetujuan,
                ]
            );
            LHE::updateOrCreate(
                ['rekapitulasi_id' => $request->id],
                [
                    'LHE_2' =>  $request->file('lhe')->storeAs('LHE/' . date('Y') . '/' . 'Tahap2/', $customName),
                ]
            );
            return redirect()->back()->with('success', 'LHE Berhasil di Simpan');
        }
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
        $satker = $request->satker;

        // Script PhpWord
        // Creating the new document...
        $phpWord = new TemplateProcessor('template_lhe.docx');

        
        if (substr($request->satker_id, -1) != 0) //cek apakah levelnya adalah bps provinsi
        // Jika levelnya bps kab/kota maka
        {
            // ambil data provinsi
            $prov = substr($request->satker_id, 0, 3) . '0';
            $provName = Satker::where('id', $prov)->first()->nama_satker;
            $nama_prov = Substr($provName, 4);
            $tembusanDaerah = $provName;
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
            'no_surat' => $request->no_surat,
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


        // $subPilar = SubPilar::where('pilar_id', 'PPA')->get();
        // $data = [];
        // $dataPertanyaan = [];

        // foreach ($subPilar as $value) {
        //     $data[] = [
        //         'subPilar' => $value->subPilar,
        //         // 'pertanyaan' => Pertanyaan::where('subpilar_id', $value->id)->first()->pertanyaan,
        //     ];
        //     foreach ($value->pertanyaan as $pt) {
        //         $data[] = [
        //             'pertanyaan' => $pt->pertanyaan,
        //         ];
        //     }
        // }

        // $phpWord->cloneRowAndSetValues('subPilar', $data);
        // $phpWord->cloneRowAndSetValues('pertanyaan', $data);

        $tahap = Pengawasan::where('satker_id', $request->satker_id)->first('tahap')->tahap;
        // Simpan hasil proses ke file Word sementara   
        $fileName = 'LHE_' . $request->satker . '_Tahap_' . $tahap . '.docx';

        $phpWord->saveAs($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
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
            'pengawasan' => $pengawasan,

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
