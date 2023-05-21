<?php

namespace App\Http\Controllers;

use App\Models\TPI;
use App\Models\Opsi;
use App\Models\Pilar;
use App\Models\SubPilar;
use App\Models\Pengawasan;
use App\Models\Pertanyaan;
use App\Models\Rekaphasil;
use App\Models\SubRincian;
use App\Models\anggota_tpi;
use App\Models\Rekapitulasi;
use Illuminate\Http\Request;
use App\Models\DeskEvaluation;
use App\Models\SelfAssessment;
use App\Models\RekapPengungkit;
use App\Http\Controllers\Controller;
use App\Models\InputField;

class DeskEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('TPI');
        return view(
            'tpi.index',
            [
                'title' => 'Desk-Evaluation Zona Integritas',
                'ketua' => TPI::where('ketua_tim', auth()->user()->id)->first(), // satu ketua membawahi 2/3 anggota
                'anggota' => anggota_tpi::where('anggota_id', auth()->user()->id)->first(),
                'pengawasan' => Pengawasan::get(),
                'dalnis' => TPI::where('dalnis', auth()->user()->id)->get(), // satu dalnis bisa 2 tim
                'nilaiHasil' => RekapHasil::where('tahun', date('Y'))->get(),
            ]


        );
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
        // Field ini hanya untuk menyimpan DeskEvaluation dari anggota tim, dikarenakan AT perlu create table terlebih dahulu
        if ($request->submit_at) {
            // Jika field merupakan input
            if ($request->input) {
                $request->validate(
                    [
                        'catatan_at'  => 'required',

                    ],
                    [
                        'catatan.required' => 'Catatan Wajib di Isi,',
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
                        return back()->withErrors('Silahkan Cek Ulang, Isian tidak boleh melebihi' . $penimbang);
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
                // validasi untuk checkbox
                $request->validate(
                    [
                        'jawaban_at' => 'required',
                        'catatan_at' => 'required',
                    ],
                    [
                        'catatan*.required' => 'Silahkan Isi Catatan, ',
                        'jawaban*.required' => 'Silahkan Pilih Jawaban, ',

                    ]
                );
            }

            $id = date('Y') . $request->satker_id . $request->pertanyaan_id;

            $data = [
                'id' => $id,
                'catatan_at' => $request->catatan_at,
                'pengawasan_id' => $request->pengawasan,
                'rekapitulasi_id' => $request->rekapitulasi_id,
            ];

            if ($request->input) {
                $data['jawaban_at'] = '-';
                $data['nilai_at'] = $nilai;
                DeskEvaluation::create($data);
                // Jika field berbentuk Input
                foreach ($request->input as $key => $input) {
                    $opsi = $request->input('opsi' . $key);
                    InputField::updateOrCreate(
                        ['id' => $opsi . $data['id']],
                        [
                            'input_at' => $input,
                        ]
                    );
                }
                $opsi0 = $request->input('opsi0');
                $dataPertama = $opsi0 . $data['id'];

                if ($opsi0 == 'PRE3A1' || $opsi0 == 'PRE3B1') {
                    InputField::where('id', $dataPertama)->update(['input_sa' => $nilai * 100]);
                } elseif ($opsi0 == 'PRE2A1') {
                    InputField::where('id', $dataPertama)->update(['input_sa' => $nilai0]);
                }
            } else {
                // Jika field berbentuk Checkbox
                $data['jawaban_at'] =  $request->jawaban_at;
                $data['nilai_at'] = Opsi::where('id', $data['jawaban_at'])->first()->bobot;
                DeskEvaluation::create($data);
            }



            // RekapPengungkit ->nilai_at
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPengungkit::where('id', $id)->first();

            $penimbang = $request->penimbang;
            if ($nilaiLama->nilai_at !== null)
                $total = $data['nilai_at'] * $penimbang + $nilaiLama->nilai_at;
            else {
                $total = $data['nilai_at'] * $penimbang;
            }
            RekapPengungkit::updateOrCreate(
                ['id' => $id],
                [
                    'rekapitulasi_id' => $rekapitulasi_id,
                    'pilar_id' => $pilar_id,
                    'nilai_at' =>  round($total, 3),
                ],
            );
        }


        return redirect()->back()->with('success', 'Jawaban Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekapitulasi  $Rekapitulasi
     * @return \Illuminate\Http\Response
     */
    public function show(Rekapitulasi $evaluasi)
    {
        $this->authorize('TPI');
        return view('tpi.lke', [
            'master' => 'Desk-Evaluation ',
            'link' => '/tpi/evaluasi',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $evaluasi,
            'pertanyaan' => Pertanyaan::count(),
            'selfAssessment' => SelfAssessment::where('rekapitulasi_id', $evaluasi->id)->count(),
            'deskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $evaluasi->id),
            'rincianPengungkit' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianHasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'nilaiPilar' => RekapPengungkit::where('rekapitulasi_id', $evaluasi->id)->get(),
            'nilaiHasil' => Rekaphasil::where('satker_id', $evaluasi->satker_id)->sum('nilai'),
            'pengawasan' => Pengawasan::where('satker_id', $evaluasi->satker_id)->first(),



        ]);
    }
    public function pertanyaan(Rekapitulasi $evaluasi, Pilar $pilar)
    {
        $this->authorize('TPI');
        return view('tpi.pertanyaan', [
            'master' => 'LKE ',
            'link' => '/tpi/evaluasi/' . $evaluasi->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
            'DeskEvaluation' => DeskEvaluation::where('rekapitulasi_id', $evaluasi->id)->get(),
            'rekap' => $evaluasi,
            'pengawasan' => Pengawasan::where('satker_id', $evaluasi->satker_id)->first(),

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeskEvaluation  $deskEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(DeskEvaluation $deskEvaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeskEvaluation  $deskEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeskEvaluation $evaluasi)
    {

        if ($request->submit_at) {
            // validasi
            $request->validate(
                [
                    'jawaban_at' => 'required',
                    'catatan_at' => 'required',
                ],
                [
                    'catatan*.required' => 'Silahkan Isi Catatan, ',
                    'jawaban*.required' => 'Silahkan Pilih Jawaban, ',

                ]
            );
            $jawaban = $request->jawaban_at;
            $nilai = Opsi::where('id', $jawaban)->first()->bobot;

            DeskEvaluation::updateOrCreate(
                ['id' => $evaluasi->id],
                [
                    'jawaban_at' => $jawaban,
                    'catatan_at' => $request->catatan_at,
                    'nilai_at' => $nilai,
                    'pengawasan_id' => $request->pengawasan,
                ]
            );
            // RekapPengungkit ->nilai_at
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPengungkit::where('id', $id)->first();
            $penimbang = $request->penimbang;
            if ($evaluasi) {
                // Jika Update
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_at -  round($evaluasi->nilai_at * $penimbang, 3);
            }
            RekapPengungkit::updateOrCreate(
                ['id' => $id],
                [
                    'rekapitulasi_id' => $rekapitulasi_id,
                    'pilar_id' => $pilar_id,
                    'nilai_at' => $total,
                ],
            );
        }
        if ($request->submit_kt) {
            // validasi
            $request->validate(
                [
                    'jawaban_kt' => 'required',
                    'catatan_kt' => 'required',
                ],
                [
                    'catatan*.required' => 'Silahkan Isi Catatan, ',
                    'jawaban*.required' => 'Silahkan Pilih Jawaban, ',

                ]
            );
            $jawaban = $request->jawaban_kt;
            $nilai = Opsi::where('id', $jawaban)->first()->bobot;

            DeskEvaluation::updateOrCreate(
                ['id' => $evaluasi->id],
                [
                    'jawaban_kt' => $jawaban,
                    'catatan_kt' => $request->catatan_kt,
                    'nilai_kt' => $nilai,
                    'pengawasan_id' => $request->pengawasan,
                ]
            );
            // RekapPengungkit ->nilai_kt
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPengungkit::where('id', $id)->first();
            $penimbang = $request->penimbang;
            if ($evaluasi) {
                // Jika Update
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_kt -  round($evaluasi->nilai_kt * $penimbang, 3);
            }
            RekapPengungkit::updateOrCreate(
                ['id' => $id],
                [
                    'rekapitulasi_id' => $rekapitulasi_id,
                    'pilar_id' => $pilar_id,
                    'nilai_kt' => $total,
                ],
            );
        }
        if ($request->submit_dl) {

            // validasi
            $request->validate(
                [
                    'jawaban_dl' => 'required',
                    'catatan_dl' => 'required',
                ],
                [
                    'catatan*.required' => 'Silahkan Isi Catatan, ',
                    'jawaban*.required' => 'Silahkan Pilih Jawaban, ',

                ]
            );
            $jawaban = $request->jawaban_dl;
            $nilai = Opsi::where('id', $jawaban)->first()->bobot;

            DeskEvaluation::updateOrCreate(
                ['id' => $evaluasi->id],
                [
                    'jawaban_dl' => $jawaban,
                    'catatan_dl' => $request->catatan_dl,
                    'nilai_dl' => $nilai,
                    'pengawasan_id' => $request->pengawasan,
                ]
            );
            // RekapPengungkit ->nilai_dl
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPengungkit::where('id', $id)->first();
            $penimbang = $request->penimbang;
            if ($evaluasi) {
                // Jika Update
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_dl -  round($evaluasi->nilai_dl * $penimbang, 3);
            }
            RekapPengungkit::updateOrCreate(
                ['id' => $id],
                [
                    'rekapitulasi_id' => $rekapitulasi_id,
                    'pilar_id' => $pilar_id,
                    'nilai_dl' => $total,
                ],
            );
        }

        return redirect()->back()->with('success', 'Jawaban Berhasil Disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeskEvaluation  $deskEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeskEvaluation $deskEvaluation)
    {
        //
    }
}
