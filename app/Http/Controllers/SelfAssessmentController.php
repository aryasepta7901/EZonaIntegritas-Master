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
        $validatedData = $request->validate(
            [
                'opsi_id' => 'required',
                'catatan'  => 'required',
                'dokumen.*' => 'mimes:pdf|max:2048',
            ],
            [
                'opsi_id.required' => 'Silahkan Pilih Jawaban,',
                'catatan.required' => 'Catatan Wajib di Isi,',
                'mimes' => 'Dokumen hanya boleh format :values,',
                'max' => 'Dokumen hanya boleh Berukuran :max,'
            ]
        );
        $validatedData['tahun'] = date('Y');
        $validatedData['pertanyaan_id'] = $request->pertanyaan_id;
        $validatedData['satker_id'] = auth()->user()->satker_id;
        $validatedData['id'] = $validatedData['tahun'] . $validatedData['satker_id'] . $validatedData['pertanyaan_id'];
        $validatedData['nilai'] = Opsi::where('id', $validatedData['opsi_id'])->first()->bobot;
        SelfAssessment::create($validatedData);

        // Dokumen

        if ($request->file('dokumen')) { //cek apakah ada dokumen yang di upload
            foreach ($request->dokumen as $key => $dokumen) {

                $id = date('Y') .  $request->input('id' . $key) .  $validatedData['satker_id'];

                UploadDokumen::updateOrCreate(
                    ['id' => $id],
                    [
                        'file' =>  $dokumen->store('dokumen'),
                        'dokumenlke_id' => $request->input('id' . $key),
                        'selfassessment_id' => $validatedData['id'],
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
            $total = round($validatedData['nilai'] * $penimbang, 2) + $nilaiLama->nilai;
        else {
            $total = round($validatedData['nilai'] * $penimbang, 2);
        }
        RekapPilar::updateOrCreate(
            ['id' => $id],
            [
                'rekapitulasi_id' => $rekapitulasi_id,
                'pilar_id' => $pilar_id,
                'nilai' => $total,
            ],
        );
        return redirect('/lke/' . $request->rekapitulasi_id . '/' . substr($validatedData['pertanyaan_id'], 0, 3))->with('success', 'Data Berhasil Ditambahkan');
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
        $validatedData = $request->validate(
            [
                'opsi_id' => 'required',
                'catatan'  => 'required',
                'dokumen.*' => 'mimes:pdf|max:2048',
            ],
            [
                'opsi_id.required' => 'Silahkan Pilih Jawaban',
                'catatan.required' => 'Catatan Wajib di Isi',
                'mimes' => 'Dokumen hanya boleh format :values',
                'max' => 'Dokumen hanya boleh Berukuran :max'
            ]
        );

        $validatedData['nilai'] = Opsi::where('id', $validatedData['opsi_id'])->first()->bobot;
        SelfAssessment::where('id', $selfAssessment->id)->update($validatedData);

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
                        'dokumenlke_id' => $request->input('id' . $key),
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
        // Jika Update
        if ($selfAssessment) {
            if ($nilaiLama)
                $total = round($validatedData['nilai'] * $penimbang, 2) + $nilaiLama->nilai -  round($selfAssessment->nilai * $penimbang, 2);
            else {
                $total = round($validatedData['nilai'] * $penimbang, 2);
            }
        } else {
            // Jika create
            if ($nilaiLama)
                $total = round($validatedData['nilai'] * $penimbang, 2) + $nilaiLama->nilai;
            else {
                $total = round($validatedData['nilai'] * $penimbang, 2);
            }
        }


        RekapPilar::updateOrCreate(
            ['id' => $id],
            [
                'rekapitulasi_id' => $rekapitulasi_id,
                'pilar_id' => $pilar_id,
                'nilai' => $total,
            ],
        );
        return redirect('/lke/' . $request->rekapitulasi_id . '/' . substr($selfAssessment->pertanyaan_id, 0, 3))->with('success', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SelfAssessment  $selfAssessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SelfAssessment $selfAssessment)
    {
        //
    }
}