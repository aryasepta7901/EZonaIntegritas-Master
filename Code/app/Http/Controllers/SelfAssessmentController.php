<?php

namespace App\Http\Controllers;

use App\Models\Opsi;
use App\Models\RekapPengungkit;
use App\Models\SelfAssessment;
use App\Models\UploadDokumen;
use App\Models\InputField;
use App\Models\Pengawasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

        // Scroll up to search
        if ($request->scroll) {
            return redirect('/satker/lke/' . $request->rekap . '/' . $request->pilar . '#' . $request->pertanyaan);
        }

        // Field dengan input value
        if ($request->input) {
            $request->validate(
                [
                    'catatan'  => 'required',
                    'dokumen.*' => 'mimes:pdf|max:2048',
                    'fileCreate.*' => 'mimes:pdf|max:2048',

                ],
                [
                    'catatan.required' => 'Catatan Wajib di Isi',
                    'mimes' => 'Dokumen hanya boleh format :values,',
                    'max' => 'Dokumen hanya boleh Berukuran maksimal 2MB,'
                ]
            );

            foreach ($request->input as $key => $input) {
                $total = $key + 1;
            }
            if ($total == 2) {
                // Logika 1
                $nilai1 = $request->input[0];
                $nilai2 = $request->input[1];
                $nilai = $nilai1 == 0 ? 0 : ($nilai2 / $nilai1);
                if ($nilai > 1) {
                    $nilai = 1;
                }
            } elseif ($total == 5) {
                $nilai1 = $request->input[1];
                $nilai2 = $request->input[2];
                $nilai3 = $request->input[3];
                $nilai4 = $request->input[4];
                $penimbang = $nilai1 + $nilai2 + $nilai3;
                if ($penimbang < $nilai4) {
                    return back()->withErrors('Silahkan Cek Ulang, Isian jumlah yang sudah melaporkan tidak boleh melebihi: ' . $penimbang);
                } else {
                    $nilai = $penimbang == 0 ? 0 : ($nilai4 / ($penimbang));
                }
            } elseif ($total == 3) {
                if ($request->pertanyaan_id == "PRC3A") {
                    // Khusus pertanyaan Penurunan pelanggaran disiplin pegawai
                    $nilai1 = $request->input[0];
                    $nilai2 = $request->input[1];
                    $nilai = $nilai1 == 0 ? 0 : ($nilai2 / ($nilai1));
                    if ($nilai > 1) {
                        $nilai = 1;
                    }
                } else {
                    $nilai1 = $request->input[1];
                    $nilai2 = $request->input[2];
                    $nilai0 = $nilai1 + $nilai2;
                    $nilai = $nilai0 == 0 ? 0 : ($nilai2 / ($nilai0));
                }
            }
        } else {
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
        }

        // SelfAssessment
        $tahun = date('Y');
        $satker_id = auth()->user()->satker_id;
        $pertanyaan_id = $request->pertanyaan_id;
        $data = [
            'tahun' => $tahun,
            'catatan' => $request->catatan,
            'rekapitulasi_id' => $request->rekapitulasi_id,
            'satker_id' => $satker_id,
            'pertanyaan_id' => $pertanyaan_id,
        ];
        // Jika field berbentuk Input
        if ($request->input) {
            $data['opsi_id'] = '-';
            $data['nilai'] = $nilai;
            $self = SelfAssessment::create($data);
            foreach ($request->input as $key => $input) {
                $opsi = $request->input('opsi' . $key);
                InputField::insert(
                    [
                        'input_sa' => $input,
                        'opsi_id' => $opsi,
                        'selfassessment_id' => $self->id,
                    ]
                );
            }
            $opsi0 = $request->input('opsi0');
            $dataPertama = InputField::where('opsi_id', $opsi0)->where('selfassessment_id', $self->id)->first()->id;

            if ($opsi0 == 'PRE3A1' || $opsi0 == 'PRE3B1') {
                InputField::where('id', $dataPertama)->update(['input_sa' => $nilai * 100]);
            } elseif ($opsi0 == 'PRE2A1') {
                InputField::where('id', $dataPertama)->update(['input_sa' => $nilai0]);
            }
        } else {
            // Jika field berbentuk Checkbox
            $data['opsi_id'] = $request->opsi_id;
            $data['nilai'] = Opsi::where('id', $data['opsi_id'])->first()->bobot;
            $self = SelfAssessment::create($data);
        }

        // Dokumen Wajib
        // $id_self = SelfAssessment::where('rekapitulasi_id', $request->rekapitulasi_id)->where('pertanyaan_id', $pertanyaan_id)->first('id')->id;
        if ($request->file('dokumen')) { //cek apakah ada dokumen yang di upload
            foreach ($request->dokumen as $key => $dokumen) {

                UploadDokumen::insert(
                    [
                        'file' =>  $dokumen->store('dokumen/' . date('Y') . '/' . $satker_id . '/' . $pertanyaan_id),
                        'name' => pathinfo($dokumen->getClientOriginalName(), PATHINFO_FILENAME),
                        'dokumenlke_id' => $request->input('id' . $key),
                        'selfassessment_id' => $self->id,
                    ]
                );
            }
        }

        // Dokumen Tambahan
        if ($request->file('fileCreate')) { //cek apakah ada dokumen yang di upload
            foreach ($request->fileCreate as $key => $file) {
                UploadDokumen::insert(
                    [
                        'file' =>  $file->store('dokumen/' . date('Y') . '/' . $satker_id . '/' . $pertanyaan_id),
                        'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        'dokumenlke_id' => $request->pertanyaan_id,
                        'selfassessment_id' => $self->id,
                    ]
                );
            }
        }

        // RekapPengungkit ->nilai
        $rekapitulasi_id = $request->rekapitulasi_id;
        $pilar_id = $request->pilar_id;
        // Cek apakah ada nilai lama
        $nilaiLama = RekapPengungkit::where('pilar_id', $pilar_id)->where('rekapitulasi_id', $rekapitulasi_id)->first();
        $penimbang = $request->penimbang;

        $dataRekap = [
            'rekapitulasi_id' => $rekapitulasi_id,
            'pilar_id' => $pilar_id,
        ];
        if ($nilaiLama !== null) {
            // Jika terdapat nilai lama
            $total = $data['nilai'] * $penimbang + $nilaiLama->nilai_sa;
            $dataRekap['nilai_sa'] = round($total, 3);
            RekapPengungkit::where('id', $nilaiLama->id)->update($dataRekap);
        } else {
            $total = $data['nilai'] * $penimbang;
            $dataRekap['nilai_sa'] = round($total, 3);
            RekapPengungkit::create($dataRekap);
        }


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
        // Field dengan input value
        if ($request->input) {

            foreach ($request->input as $key => $input) {
                $total = $key + 1;
            }
            if ($total == 2) {
                // Logika 1
                $nilai1 = $request->input[0];
                $nilai2 = $request->input[1];
                $nilai = $nilai1 == 0 ? 0 : ($nilai2 / $nilai1);
                if ($nilai > 1) {
                    $nilai = 1;
                }
            } elseif ($total == 5) {
                $nilai1 = $request->input[1];
                $nilai2 = $request->input[2];
                $nilai3 = $request->input[3];
                $nilai4 = $request->input[4];
                $penimbang = $nilai1 + $nilai2 + $nilai3;
                if ($penimbang < $nilai4) {
                    return back()->withErrors('Silahkan Cek Ulang, Isian tidak boleh melebihi: ' . $penimbang);
                } else {
                    $nilai = $penimbang == 0 ? 0 : ($nilai4 / ($penimbang));
                }
            } elseif ($total == 3) {
                if ($request->pertanyaan_id == "PRC3A") {
                    // Khusus pertanyaan Penurunan pelanggaran disiplin pegawai
                    $nilai1 = $request->input[0];
                    $nilai2 = $request->input[1];
                    $nilai = $nilai1 == 0 ? 0 : ($nilai2 / ($nilai1));
                    if ($nilai > 1) {
                        $nilai = 1;
                    }
                } else {
                    $nilai1 = $request->input[1];
                    $nilai2 = $request->input[2];
                    $nilai0 = $nilai1 + $nilai2;
                    $nilai = $nilai0 == 0 ? 0 : ($nilai2 / ($nilai0));
                }
            }
        }
        $request->validate(
            [
                // 'opsi_id' => 'required',
                'catatan'  => 'required',
                'dokumen.*' => 'mimes:pdf|max:2048',
                'fileUpdate.*' => 'mimes:pdf|max:2048',
                'fileCreate.*' => 'mimes:pdf|max:2048',
            ],
            [
                // 'opsi_id.required' => 'Silahkan Pilih Jawaban',
                'catatan.required' => 'Catatan Wajib di Isi',
                'mimes' => 'Dokumen hanya boleh format :values',
                'max' => 'Dokumen hanya boleh Berukuran maksimal 2MB'
            ]
        );

        if ($request->input) {
            $data['nilai'] = $nilai;
            $data['catatan'] = $request->catatan;
            SelfAssessment::where('id', $selfAssessment->id)->update($data);
            // Jika field berbentuk Input
            foreach ($request->input as $key => $input) {
                $opsi = $request->input('opsi' . $key);
                $id = InputField::where('opsi_id', $opsi)->where('selfassessment_id', $selfAssessment->id)->first()->id;
                InputField::updateOrCreate(
                    ['id' => $id],
                    [
                        'input_sa' => $input,
                        'opsi_id' => $opsi,
                        'selfassessment_id' => $selfAssessment->id,
                    ]
                );
            }
            // Update data pertama
            $opsi0 = $request->input('opsi0');
            $dataPertama = InputField::where('opsi_id', $opsi0)->where('selfassessment_id', $selfAssessment->id)->first()->id;

            if ($opsi0 == 'PRE3A1' || $opsi0 == 'PRE3B1') {
                InputField::where('id', $dataPertama)->update(['input_sa' => $nilai * 100]);
            } elseif ($opsi0 == 'PRE2A1') {
                InputField::where('id', $dataPertama)->update(['input_sa' => $nilai0]);
            }
        } else {
            // Jika field berbentuk Checkbox
            $data = [
                'opsi_id' => $request->opsi_id,
                'catatan' => $request->catatan,
            ];
            $data['nilai'] = Opsi::where('id', $data['opsi_id'])->first()->bobot;
            SelfAssessment::where('id', $selfAssessment->id)->update($data);
        }

        // Dokumen Wajib
        if ($request->file('dokumen')) { //cek apakah ada dokumen yang di upload
            foreach ($request->dokumen as $key => $dokumen) {

                // Ambil File lamanya
                $oldFile = UploadDokumen::where('dokumenlke_id', $request->input('id' . $key))->where('selfassessment_id', $selfAssessment->id)->first();
                if ($oldFile) {
                    // jika ada gambar lama maka hapus
                    Storage::delete($oldFile->file);
                    // Update
                    UploadDokumen::updateOrCreate(
                        ['id' => $oldFile->id],
                        [
                            'file' =>  $dokumen->store('dokumen/' . date('Y') . '/' . $selfAssessment->satker_id . '/' . $selfAssessment->pertanyaan_id),
                            'name' => pathinfo($dokumen->getClientOriginalName(), PATHINFO_FILENAME),
                            'dokumenlke_id' => $request->input('id' . $key),
                            'selfassessment_id' => $selfAssessment->id,
                        ]
                    );
                } else {
                    // Create
                    UploadDokumen::insert(
                        [
                            'file' =>  $dokumen->store('dokumen/' . date('Y') . '/' . $selfAssessment->satker_id . '/' . $selfAssessment->pertanyaan_id),
                            'name' => pathinfo($dokumen->getClientOriginalName(), PATHINFO_FILENAME),
                            'dokumenlke_id' => $request->input('id' . $key),
                            'selfassessment_id' => $selfAssessment->id,
                        ]
                    );
                }
            }
        }
        // file tambahan {Update}
        if ($request->file('fileUpdate')) { //cek apakah ada dokumen yang di upload
            foreach ($request->fileUpdate as $key => $fileUpdate) {
                // Ambil File lamanya
                $oldFile = UploadDokumen::where('dokumenlke_id', $request->pertanyaan_id)->where('name', $request->input('name' . $key))->where('selfassessment_id', $selfAssessment->id)->first();
                if ($oldFile) {
                    // jika ada gambar lama maka hapus
                    Storage::delete($oldFile->file);
                }
                UploadDokumen::updateOrCreate(
                    ['id' => $oldFile->id],
                    [
                        'file' =>  $fileUpdate->store('dokumen/' . date('Y') . '/' . $selfAssessment->satker_id . '/' . $selfAssessment->pertanyaan_id),
                        'name' => pathinfo($fileUpdate->getClientOriginalName(), PATHINFO_FILENAME),
                        'dokumenlke_id' => $request->pertanyaan_id,
                        'selfassessment_id' => $selfAssessment->id,
                    ]
                );
            }
        }

        // file tambahan {Create}
        if ($request->file('fileCreate')) { //cek apakah ada dokumen yang di upload
            foreach ($request->fileCreate as $key => $file) {
                UploadDokumen::updateOrCreate(
                    [
                        'file' =>  $file->store('dokumen/' . date('Y') . '/' . $selfAssessment->satker_id . '/' . $selfAssessment->pertanyaan_id),
                        'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                        'dokumenlke_id' => $request->pertanyaan_id,
                        'selfassessment_id' => $selfAssessment->id,
                    ]
                );
            }
        }

        // RekapPengungkit ->nilai
        $rekapitulasi_id = $request->rekapitulasi_id;
        $pilar_id = $request->pilar_id;
        // Cek apakah ada nilai lama pada rekappilar
        $nilaiLama = RekapPengungkit::where('pilar_id', $pilar_id)->where('rekapitulasi_id', $rekapitulasi_id)->first(); //ambil nilai lama
        $penimbang = $request->penimbang;
        // Cek apakah melakukan update atau create
        if ($selfAssessment) {
            // Jika Update
            $total = $data['nilai'] * $penimbang + $nilaiLama->nilai_sa - $selfAssessment->nilai * $penimbang;
        }
        RekapPengungkit::updateOrCreate(
            ['id' => $nilaiLama->id],
            [
                'rekapitulasi_id' => $rekapitulasi_id,
                'pilar_id' => $pilar_id,
                'nilai_sa' => round($total, 3),
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
        return redirect()->back()->with('success', ' Dokumen Berhasil di Hapus');
    }
}
