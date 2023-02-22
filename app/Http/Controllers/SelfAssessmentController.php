<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\RekapPilar;
use App\Models\SelfAssessment;
use App\Models\UploadDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SelfAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        // validasi
        $request->validate(
            [
                'opsi_id' => 'required',
                'catatan'  => 'required',
                'dokumen.*' => 'mimes:pdf|max:2048',
                'fileCreate.*' => 'mimes:pdf|max:2048',

            ],
            [
                'opsi_id.required' => 'Silahkan Pilih Jawaban,',
                'catatan.required' => 'Catatan Wajib di Isi,',
                'mimes' => 'Dokumen hanya boleh format :values,',
                'max' => 'Dokumen hanya boleh Berukuran :max,'
            ]
        );
        // SelfAssessment
        $tahun = date('Y');
        $satker_id = auth()->user()->satker_id;
        $pertanyaan_id = $request->pertanyaan_id;
        $data = [
            'id' => $tahun . $satker_id . $pertanyaan_id,
            'tahun' => $tahun,
            'opsi_id' => $request->opsi_id,
            'catatan' => $request->catatan,
            'rekapitulasi_id' => $request->rekapitulasi_id,
            'satker_id' => $satker_id,
            'pertanyaan_id' => $pertanyaan_id,
        ];
        $data['nilai'] = Opsi::where('id', $data['opsi_id'])->first()->bobot;
        SelfAssessment::create($data);
        // Dokumen 
        if ($request->file('dokumen')) { //cek apakah ada dokumen yang di upload
            foreach ($request->dokumen as $key => $dokumen) {
                $id = date('Y') .  $request->input('id' . $key) .  $data['satker_id'];
                UploadDokumen::updateOrCreate(
                    ['id' => $id],
                    [
                        'file' =>  $dokumen->store('dokumen'),
                        'name' => $dokumen->getClientOriginalName(),
                        'dokumenlke_id' => $request->input('id' . $key),
                        'selfassessment_id' => $data['id'],
                    ]
                );
            }
        }
        // file tambahan Create
        if ($request->file('fileCreate')) { //cek apakah ada dokumen yang di upload

            foreach ($request->fileCreate as $key => $file) {
                // cek data terakhir yang masuk
                $dataLama =  UploadDokumen::where('dokumenlke_id', $request->pertanyaan_id)->where('selfassessment_id', $data['id'])->orderBy('id', 'DESC')->first();
                if ($dataLama) {
                    $id = substr($dataLama->id, -1, 1); //ambil angka 
                    $id += 1; //tambahkan satu
                } else {
                    $id = 1;
                }
                $id =    $data['id'] . $id;
                UploadDokumen::updateOrCreate(
                    ['id' => $id],
                    [
                        'file' =>  $file->store('dokumen'),
                        'name' => $file->getClientOriginalName(),
                        'dokumenlke_id' => $request->pertanyaan_id,
                        'selfassessment_id' => $data['id'],
                    ]
                );
            }
        }

        // RekapPilar ->nilai
        $rekapitulasi_id = $request->rekapitulasi_id;
        $pilar_id = $request->pilar_id;
        $id = $pilar_id . $rekapitulasi_id;
        // Cek apakah ada nilai lama
        $nilaiLama = RekapPilar::where('id', $id)->first();
        $penimbang = $request->penimbang;
        if ($nilaiLama !== null)
            $total = round($data['nilai'] * $penimbang, 2) + $nilaiLama->nilai_sa;
        else {
            $total = round($data['nilai'] * $penimbang, 2);
        }
        RekapPilar::updateOrCreate(
            ['id' => $id],
            [
                'rekapitulasi_id' => $rekapitulasi_id,
                'pilar_id' => $pilar_id,
                'nilai_sa' => $total,
            ],
        );
        return redirect()->back()->with('success', 'Jawaban Berhasil Disimpan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function show(SelfAssessment $selfAssessment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function edit(SelfAssessment $selfAssessment)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SelfAssessment $selfAssessment)
    {
        $request->validate(
            [
                'opsi_id' => 'required',
                'catatan'  => 'required',
                'dokumen.*' => 'mimes:pdf|max:2048',
                'fileUpdate.*' => 'mimes:pdf|max:2048',
                'fileCreate.*' => 'mimes:pdf|max:2048',
            ],
            [
                'opsi_id.required' => 'Silahkan Pilih Jawaban',
                'catatan.required' => 'Catatan Wajib di Isi',
                'mimes' => 'Dokumen hanya boleh format :values',
                'max' => 'Dokumen hanya boleh Berukuran :max'
            ]
        );
        $data = [
            'opsi_id' => $request->opsi_id,
            'catatan' => $request->catatan,
        ];
        $data['nilai'] = Opsi::where('id', $data['opsi_id'])->first()->bobot;
        SelfAssessment::where('id', $selfAssessment->id)->update($data);

        // Dokumen
        if ($request->file('dokumen')) { //cek apakah ada dokumen yang di upload
            foreach ($request->dokumen as $key => $dokumen) {
                $id = date('Y') . $request->input('id' . $key) . $selfAssessment->satker_id;

                // Ambil File lamanya
                $oldFile = UploadDokumen::where('id', $id)->first();
                if ($oldFile) {
                    // jika ada gambar lama maka hapus
                    Storage::delete($oldFile->file);
                }
                UploadDokumen::updateOrCreate(
                    ['id' => $id],
                    [
                        'file' =>  $dokumen->store('dokumen'),
                        'name' => $dokumen->getClientOriginalName(),
                        'dokumenlke_id' => $request->input('id' . $key),
                        'selfassessment_id' => $selfAssessment->id,
                    ]
                );
            }
        }
        // file tambahan {Update}
        if ($request->file('fileUpdate')) { //cek apakah ada dokumen yang di upload
            foreach ($request->fileUpdate as $key => $fileUpdate) {
                $id =  $request->input('upload_id' . $key);

                // Ambil File lamanya
                $oldFile = UploadDokumen::where('id', $id)->first();
                if ($oldFile) {
                    // jika ada gambar lama maka hapus
                    Storage::delete($oldFile->file);
                }
                UploadDokumen::updateOrCreate(
                    ['id' => $id],
                    [
                        'file' =>  $fileUpdate->store('dokumen'),
                        'name' => $fileUpdate->getClientOriginalName(),
                        'dokumenlke_id' => $request->pertanyaan_id,
                        'selfassessment_id' => $selfAssessment->id,
                    ]
                );
            }
        }

        // file tambahan {Create}
        if ($request->file('fileCreate')) { //cek apakah ada dokumen yang di upload
            foreach ($request->fileCreate as $key => $file) {
                // cek data terakhir yang masuk
                $dataLama =  UploadDokumen::where('dokumenlke_id', $request->pertanyaan_id)->where('selfassessment_id', $selfAssessment->id)->orderBy('id', 'DESC')->first();
                if ($dataLama) {

                    $id = substr($dataLama->id, -1, 1); //ambil angka 
                    $id += 1; //tambahkan satu
                } else {
                    $id = 1;
                }
                $id = $selfAssessment->id . $id;
                UploadDokumen::updateOrCreate(
                    ['id' => $id],
                    [
                        'file' =>  $file->store('dokumen'),
                        'name' => $file->getClientOriginalName(),
                        'dokumenlke_id' => $request->pertanyaan_id,
                        'selfassessment_id' => $selfAssessment->id,
                    ]
                );
            }
        }

        // RekapPilar ->nilai
        $rekapitulasi_id = $request->rekapitulasi_id;
        $pilar_id = $request->pilar_id;
        $id = $pilar_id . $rekapitulasi_id;
        // Cek apakah ada nilai lama pada rekappilar
        $nilaiLama = RekapPilar::where('id', $id)->first(); //ambil nilai lama
        $penimbang = $request->penimbang;
        // Cek apakah melakukan update atau create
        if ($selfAssessment) {
            // Jika Update
            $total = round($data['nilai'] * $penimbang, 2) + $nilaiLama->nilai_sa -  round($selfAssessment->nilai * $penimbang, 2);
        }
        RekapPilar::updateOrCreate(
            ['id' => $id],
            [
                'rekapitulasi_id' => $rekapitulasi_id,
                'pilar_id' => $pilar_id,
                'nilai_sa' => $total,
            ],
        );
        return redirect()->back()->with('success', 'Jawaban Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(UploadDokumen $selfAssessment)
    {
        if ($selfAssessment->file) {
            // jika ada gambar lama maka hapus
            Storage::delete($selfAssessment->file);
        }
        UploadDokumen::destroy($selfAssessment->id);
        return redirect()->back()->with('success', ' Dokumen Has Ben Deleted');
    }
}
