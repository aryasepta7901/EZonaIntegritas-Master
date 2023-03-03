<?php

namespace App\Http\Controllers;

use App\Models\anggota_tpi;
use App\Models\TPI;
use App\Models\DeskEvaluation;
use App\Models\Pengawasan;
use App\Models\Pilar;
use App\Models\SubRincian;
use App\Models\Rekappilar;
use App\Models\Rekaphasil;
use App\Models\Rekapitulasi;
use App\Models\SubPilar;
use App\Models\Opsi;
use Illuminate\Http\Request;

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
                'ketua' => TPI::where('ketua_tim', auth()->user()->id)->first(),
                'anggota' => anggota_tpi::where('anggota_id', auth()->user()->id)->first(),
                'dalnis' => TPI::where('dalnis', auth()->user()->id)->get(),
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
            $id = date('Y') . $request->satker_id . $request->pertanyaan_id;

            DeskEvaluation::updateOrCreate(
                ['id' => $id],
                [
                    'jawaban_at' => $jawaban,
                    'catatan_at' => $request->catatan_at,
                    'nilai_at' => $nilai,
                    'pengawasan_id' => $request->pengawasan,
                    'rekapitulasi_id' => $request->rekapitulasi_id,

                ]
            );
            // RekapPilar ->nilai_at
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPilar::where('id', $id)->first();

            $penimbang = $request->penimbang;
            if ($nilaiLama->nilai_at !== null)
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_at;
            else {
                $total = round($nilai * $penimbang, 3);
            }
            RekapPilar::updateOrCreate(
                ['id' => $id],
                [
                    'rekapitulasi_id' => $rekapitulasi_id,
                    'pilar_id' => $pilar_id,
                    'nilai_at' => $total,
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
            'link' => 'tpi/evaluasi',
            'title' => 'Lembar Kerja Evaluasi',
            'rekap' => $evaluasi,
            'subrincian' => SubRincian::where('rincian_id', 'p')->get(),
            'rincianhasil' => Pilar::where('subrincian_id', 'LIKE', '%' . 'H' . '%')->get(),
            'nilaiPilar' => Rekappilar::where('rekapitulasi_id', $evaluasi->id)->get(),
            'nilaiHasil' => Rekaphasil::where('satker_id', $evaluasi->satker_id)->sum('nilai'),
            // Permasalahan
            'anggota' => anggota_tpi::where('anggota_id', auth()->user()->id)->first(),
            'pengawasan' => Pengawasan::where('satker_id', $evaluasi->satker_id)->first(),



        ]);
    }
    public function show2(Rekapitulasi $evaluasi, Pilar $pilar)
    {
        $this->authorize('TPI');
        return view('tpi.pertanyaan', [
            'master' => 'LKE ',
            'link' => 'tpi/evaluasi/' . $evaluasi->id,
            'title' => $pilar->pilar,
            'pilar' => $pilar,
            'subPilar' => SubPilar::where('pilar_id', $pilar->id)->get(),
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
            // RekapPilar ->nilai_at
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPilar::where('id', $id)->first();
            $penimbang = $request->penimbang;
            if ($evaluasi) {
                // Jika Update
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_at -  round($evaluasi->nilai_at * $penimbang, 3);
            }
            RekapPilar::updateOrCreate(
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
            // RekapPilar ->nilai_kt
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPilar::where('id', $id)->first();
            $penimbang = $request->penimbang;
            if ($evaluasi) {
                // Jika Update
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_kt -  round($evaluasi->nilai_kt * $penimbang, 3);
            }
            RekapPilar::updateOrCreate(
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
            // RekapPilar ->nilai_dl
            $rekapitulasi_id = $request->rekapitulasi_id;
            $pilar_id = $request->pilar_id;
            $id = $pilar_id . $rekapitulasi_id;
            // Cek apakah ada nilai lama
            $nilaiLama = RekapPilar::where('id', $id)->first();
            $penimbang = $request->penimbang;
            if ($evaluasi) {
                // Jika Update
                $total = round($nilai * $penimbang, 3) + $nilaiLama->nilai_dl -  round($evaluasi->nilai_dl * $penimbang, 3);
            }
            RekapPilar::updateOrCreate(
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
