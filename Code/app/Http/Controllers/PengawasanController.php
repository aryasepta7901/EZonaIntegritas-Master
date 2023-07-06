<?php

namespace App\Http\Controllers;

use App\Mail\DLEmailDL;
use App\Models\Pengawasan;
use App\Models\Satker;
use App\Models\TPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PengawasanController extends Controller
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

        // pengawasan_satker
        $validatedData = $request->validate(
            [
                'anggota_id' => 'required',
                'satker_id'  => 'required',
            ],
            [
                'anggota_id.required' => 'Anggota TPI Wajib di Pilih',
                'satker_id.required' => 'Wilayah Pengawasan Satuan Kerja wajib di isi',
            ]
        );

        foreach ($request->satker_id as $key => $satker) {
            $id = $validatedData['anggota_id'] . $satker;
            Pengawasan::updateOrCreate(
                ['id' => $id],
                [
                    'tpi_id' =>  $request->tpi_id,
                    'anggota_id' => $validatedData['anggota_id'],
                    'satker_id' =>  $satker,
                    'tahap' => 1,
                    'status' => 0,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data Pengawasan Berhasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function show(Pengawasan $pengawasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengawasan $pengawasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengawasan $pengawasan)
    {
        // Kirim Notif Gmail
        $id_satker = $request->satker_id;
        $tpi_id = $pengawasan->tpi_id;
        $tpi = TPI::where('id', $tpi_id)->first();

        $dalnis = $tpi->dalnis;
        $nama_satker = Satker::where('id', $id_satker)->first('nama_satker')->nama_satker;
        $data = [
            'title' => 'Hasil Penilaian Evaluasi:' . $nama_satker . '[Tahap ' . $pengawasan->tahap . ']',
            'nama_satker' => $nama_satker,
        ];
        // Untuk kirim LKE ke ketua tim dan dalnis
        Pengawasan::where('id', $pengawasan->id)->update(['status' => $request->status]);
        if ($request->status == 1) {
            // informasi ketua_tim
            $ketua = $tpi->ketua_tim;
            $user = User::where('id', $ketua)->first();
            $email = $user->email;
            $name = $user->name;
            $data['name'] = $name;
            $data['nilai'] = $request->nilai_at;
            $data['status'] = 'Anggota Tim';
            $kata = 'LKE Berhasil di Kirim ke Ketua Tim';
        } elseif ($request->status == 2) {
            // informasi dalnis
            $dalnis = $tpi->dalnis;
            $user = User::where('id', $dalnis)->first();
            $email = $user->email;
            $name = $user->name;
            $data['name'] = $name;
            $data['nilai'] = $request->nilai_dalnis;
            $data['status'] = 'Ketua Tim';
            $kata = ' LKE Berhasil di Kirim ke Pengendali Teknis';
        } elseif ($request->status == 0) {
            $kata = ' LKE dikembalikan ke Anggota Tim';
        }
        Mail::to($email)->send(new DLEmailDL($data));


        return redirect('/tpi/evaluasi')->with('success', $kata);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengawasan_satker  $pengawasan_satker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengawasan $pengawasan)
    {
        Pengawasan::destroy($pengawasan->id);
        return redirect()->back()->with('success', 'Data Pengawasan Berhasil di Hapus');
    }
}
