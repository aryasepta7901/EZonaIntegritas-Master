<?php

namespace App\Http\Controllers;

use App\Models\anggota_tpi;
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
                'anggota' => anggota_tpi::where('anggota_id', auth()->user()->id)->first(),


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
                $total = round($nilai * $penimbang, 2) + $nilaiLama->nilai_at;
            else {
                $total = round($nilai * $penimbang, 2);
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
            'nilai' => Rekappilar::where('rekapitulasi_id', $evaluasi->id)->sum('nilai_sa'),
            'nilaiHasil' => Rekaphasil::where('satker_id', $evaluasi->satker_id)->sum('nilai'),

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
            'pengawasan' => Pengawasan::where('anggota_id', auth()->user()->id)->where('satker_id', $evaluasi->satker_id)->first(),

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
                $total = round($nilai * $penimbang, 2) + $nilaiLama->nilai_at -  round($evaluasi->nilai_at * $penimbang, 2);
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
