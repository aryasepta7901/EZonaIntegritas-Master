<?php

namespace App\Http\Controllers;

use App\Mail\EPEmailDL;
use App\Models\LHE;
use App\Models\Pengawasan;
use App\Models\RekapHasil;
use App\Models\Rekapitulasi;
use App\Models\Satker;
use App\Models\TPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratPersetujuanProvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('EvalProv');

        return view('EvalProv.surat', [
            'master' => 'Penilaian Pendahuluan',
            'link' => '/prov/evaluasi',
            'title' => 'Surat Pengantar',
            'rekap' => Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->whereIn('status', [4, 5, 6, 7, 8])->get(),
            'nilaiHasil' => RekapHasil::where('tahun', date('Y'))->get(),


        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        // Kirim Surat (Gmail)
        $id_prov = $request->satker_id;
        $nama_prov = Satker::where('id', $id_prov)->first('nama_satker')->nama_satker;
        foreach ($request->satker as $key => $satker) {
            $id_kabkota[] = $satker;
            $tpi[] = Pengawasan::where('satker_id', $satker)->first()->tpi_id;
            $anggota[] = Pengawasan::where('satker_id', $satker)->first()->anggota_id;
        }
        foreach ($id_kabkota as $item) {
            $rekapitulasi[] = Rekapitulasi::where('satker_id', $item)->first();
        }
        foreach ($tpi as $item) {
            // ambil id_user
            $dalnis[] = TPI::where('id', $item)->first('dalnis')->dalnis;
            $ketua[] = TPI::where('id', $item)->first('ketua_tim')->ketua_tim;
        }
        $tpi_array = array_merge($dalnis, $ketua, $anggota);
        $tpi = array_unique($tpi_array);
        foreach ($tpi as $item) {
            // ambil email
            $user[] = User::where('id', $item)->first('email')->email;
        }

        // Kirim Notif Gmail
        $data = [
            'title' => 'Hasil Penilaian Pendahuluan ' . $nama_prov,
            'rekapitulasi' => $rekapitulasi,
            'nama_prov' => $nama_prov,
        ];
        Mail::to($user)->send(new EPEmailDL($data));

        if ($request->file('surat')) { //cek apakah ada dokumen yang di upload
            // Ambil File lamanya
            $rekap = Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->where('tahun', date('Y'))->first('id');

            if ($rekap->LHE->surat_pengantar_prov) {
                // jika ada file lama maka hapus
                Storage::delete($rekap->LHE->surat_pengantar_prov);
            }
            $customName = $request->satker_id . '-' . $request->file('surat')->getClientOriginalName();

            Rekapitulasi::where('id', $request->id)->update(['status' => 4]);
            foreach ($request->id as $key => $id) {
                Rekapitulasi::where('id', $id)->update(['status' => 4]);
                LHE::updateOrCreate(
                    ['rekapitulasi_id' => $id],
                    [
                        'surat_pengantar_prov' =>  $request->file('surat')->storeAs('surat_pengantar/prov/' . date('Y') . '/', $customName),
                    ]
                );
            }
        }
        return redirect()->back()->with('success', 'Surat Pengantar Berhasil di Simpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function edit(rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rekapitulasi $rekapitulasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rekapitulasi  $rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(rekapitulasi $surat, Request $request)
    {
        $rekap = Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->where('status', 4)->first();


        if ($rekap->LHE->surat_pengantar_prov) {
            // jika ada file lama maka hapus
            Storage::delete($rekap->LHE->surat_pengantar_prov);
        }
        foreach ($request->id as $key => $id) {
            LHE::updateOrCreate(
                ['rekapitulasi_id' => $id],
                [
                    'surat_pengantar_prov' =>  '',
                ]
            );
        }
        return redirect()->back()->with('success', 'Surat Pengantar Berhasil di hapus');
    }
    // Cetak Template Surat
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
        $phpWord = new TemplateProcessor('template_prov.docx');

        $rekap = Rekapitulasi::where('satker_id', 'LIKE', '%' . substr(auth()->user()->satker_id, 0, 3) . '%')->whereIn('status', [4, 5, 6, 7])->get();

        $phpWord->setValues([
            'y' => date('Y'),
            'no_surat' => $request->no_surat,
            'tanggal' => date('d F Y'),
            'daerah' => substr($request->satker, 3),
        ]);
        $dataSatker = [];
        $i = 1;
        foreach ($rekap as $value) {
            $dataSatker[] = [
                'no' => $i++,
                'satker' =>   $value->satker->nama_satker,
                'predikat' =>   $value->predikat,
            ];
        }
        $i = 2;
        $phpWord->cloneRowAndSetValues('satker', $dataSatker);
        $tembusanSatker = [];
        foreach ($rekap as $value) {
            $tembusanSatker[] = [
                'no' => $i++,
                'satker' =>   $value->satker->nama_satker,
            ];
        }
        $phpWord->cloneRowAndSetValues('satker', $tembusanSatker);


        // Simpan hasil proses ke file Word sementara
        $fileName = 'Usulan_WBK-WBBM_' . $request->satker . '.docx';
        $phpWord->saveAs($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
