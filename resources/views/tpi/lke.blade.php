@extends('layouts.backEnd.main')

@section('content')
    @php
        $nilai_sa = 0;
        $nilai_at = 0;
        $nilai_kt = 0;
        $nilai_dl = 0;
    @endphp
    @foreach ($nilaiPilar as $n)
        @php
            $nilai_sa += round($n->nilai_sa, 2);
            $nilai_at += round($n->nilai_at, 2);
            $nilai_kt += round($n->nilai_kt, 2);
            $nilai_dl += round($n->nilai_dl, 2);
        @endphp
    @endforeach
    {{-- @php
    $nilai_sa += $nilaiHasil;
    @endphp --}}
    {{-- Self Assessment --}}
    @php
        $tot_jumlah_soal = $pertanyaan;
        $tot_soal_terjawab = $selfAssessment;
        $TotprogressSelf = round(($tot_soal_terjawab * 100) / $tot_jumlah_soal, 2);
    @endphp
    {{-- Desk Evaluation --}}
    @if (auth()->user()->level_id == 'AT')
        @php
            $tot_soal_terjawab = $deskEvaluation->count('jawaban_at');
            $aktor = 'Anggota Tim';
        @endphp
    @elseif(auth()->user()->level_id == 'KT')
        @php
            $tot_soal_terjawab = $deskEvaluation->count('jawaban_kt');
            $aktor = 'Ketua Tim';
        @endphp
    @elseif(auth()->user()->level_id == 'DL')
        @php
            $tot_soal_terjawab = $deskEvaluation->count('jawaban_dl');
            $aktor = 'Pengendali Teknis';
        @endphp
    @endif
    @php
        $TotprogressDesk = round(($tot_soal_terjawab * 100) / $tot_jumlah_soal, 2);
        
    @endphp
    @if ($rekap->status == 4)

        @if ($rekap->LHE->surat_pengantar_prov != '')
            {{-- Anggota Tim --}}
            @if ($pengawasan->status == 0 && auth()->user()->level_id == 'AT')
                <div class="col-lg-6 mb-3">
                    <button class="btn btn-info" data-toggle="modal" data-target="#lihat"><i class="fa fa-eye">
                        </i> Lihat Perubahan</button>
                </div>
                @if ($TotprogressDesk == $TotprogressSelf)
                    <div class="col-lg-6 mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary m-2" data-toggle="modal" data-target="#at"><i class="fa fa-save">
                            </i> Simpan</button>
                    </div>
                @else
                    <div class="col-lg-6 mb-3 d-flex justify-content-end">
                        <div class="alert alert-info alert-dismissible">
                            <h5><i class="icon fas fa-info"></i> Note</h5>
                            Harap Lengkapi Desk-Evaluation agar bisa kirim LKE kepada Ketua
                            Tim
                        </div>
                    </div>
                @endif
                {{-- Simpan AT --}}
                <div class="modal fade" id="at">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Apakah Kamu Yakin untuk Mengirim LKE?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                $pengawasan_id = $pengawasan->anggota_id . $rekap->satker->id;
                            @endphp
                            <form method="post" action="/pengawasan/{{ $pengawasan_id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="pengawasan_id" value="{{ $pengawasan_id }}">
                                    <input type="hidden" name="status" value="1">
                                    <p> <b> Note:</b> <br></p>
                                    <p>LKE akan dilanjutkan kepada </p>
                                    <p>Nilai Desk Evaluation Anggota Tim : <b class="badge badge-info">
                                            {{ $nilai_sa }}</b> </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endif
            {{-- Ketua Tim --}}
            @if ($pengawasan->status == 1 && auth()->user()->level_id == 'KT')
                <div class="col-lg-6 mb-3">
                    <button class="btn btn-info" data-toggle="modal" data-target="#lihat"><i class="fa fa-eye">
                        </i> Lihat Perubahan</button>
                </div>
                <div class="col-lg-6 mb-3 d-flex justify-content-end">
                    <button class="btn btn-warning m-2" data-toggle="modal" data-target="#at"><i class="fa fa-backward">
                        </i> Kembalikan ke AT</button>
                    <button class="btn btn-primary m-2" data-toggle="modal" data-target="#kt"><i class="fa fa-save">
                        </i> Simpan</button>

                </div>
                {{-- Simpan KT(Teruskan ke DL) --}}
                <div class="modal fade" id="kt">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Apakah Kamu Yakin untuk Mengirim LKE?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                $pengawasan_id = $pengawasan->anggota_id . $rekap->satker->id;
                            @endphp
                            <form method="post" action="/pengawasan/{{ $pengawasan_id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="pengawasan_id" value="{{ $pengawasan_id }}">
                                    <input type="hidden" name="status" value="2">
                                    <p> <b> Note:</b> <br></p>
                                    <p>LKE akan dilanjutkan kepada Pengendali Teknis </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Kembalikan ke AT --}}
                <div class="modal fade" id="at">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Apakah Kamu Yakin untuk Mengirim LKE?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                $pengawasan_id = $pengawasan->anggota_id . $rekap->satker->id;
                            @endphp
                            <form method="post" action="/pengawasan/{{ $pengawasan_id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="pengawasan_id" value="{{ $pengawasan_id }}">
                                    <input type="hidden" name="status" value="0">
                                    <p> <b> Note:</b> <br></p>
                                    <p>LKE akan dikembalikan kepada Anggota Tim </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endif
            {{-- Pengendali Teknis --}}
            @if ($pengawasan->status == 2 && auth()->user()->level_id == 'DL')
                <div class="col-lg-6 mb-3">
                    <button class="btn btn-info" data-toggle="modal" data-target="#lihat"><i class="fa fa-eye">
                        </i> Lihat Perubahan</button>
                </div>
                <div class="col-lg-6 mb-3 d-flex justify-content-end">
                    @if ($pengawasan->tahap == 1)
                        <a href="/tpi/lhe/{{ $rekap->id }}" class="btn btn-warning m-2"><i class="fa fa-save">
                            </i> Revisi</a>
                    @elseif($pengawasan->tahap == 2)
                        <a href="/tpi/lhe/{{ $rekap->id }}" class="btn btn-success m-2"><i class="fa fa-save">
                            </i> Setuju</a>
                        <button class="btn btn-danger m-2" data-toggle="modal" data-target="#tolak"><i
                                class="fa fa-save">
                            </i> Tolak</button>
                    @endif


                </div>
                {{-- Setuju LKE --}}
                <div class="modal fade" id="setuju">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Apakah Kamu Yakin untuk Menyetujui LKE?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form method="post" action="/prov/evaluasi/{{ $rekap->id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $rekap->id }}">
                                    <input type="hidden" name="status" value="6">
                                    <p> <b> Note:</b> <br></p>
                                    <p>LKE yang telah disetujui akan menjadi rekomendasi dalam pengajuan ZI kepada
                                        KemenpanRB
                                    </p>


                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Revisi --}}
                {{-- <div class="modal fade" id="revisi">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Apakah Kamu Yakin untuk Mengirimkan Kembali LKE?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @php
                                $pengawasan_id = $pengawasan->anggota_id . $rekap->satker->id;
                            @endphp
                            <form method="post" action="/prov/evaluasi/{{ $rekap->id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $rekap->id }}">
                                    <input type="hidden" name="status" value="5">
                                    <input type="hidden" name="statusPengawasan" value="0">
                                    <input type="hidden" name="pengawasan_id" value="{{ $pengawasan_id }}">
                                    <p> <b> Note:</b> <br></p>
                                    <p>LKE akan dikembalikan ke {{ $rekap->satker->nama_satker }} untuk diperbaiki kembali
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>

                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div> --}}
                {{-- Tolak --}}
                {{-- <div class="modal fade" id="tolak">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Apakah Kamu Yakin untuk Menolak LKE?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form method="post" action="/prov/evaluasi/{{ $rekap->id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $rekap->id }}">
                                    <input type="hidden" name="status" value="7">
                                    <p> <b> Note:</b> <br></p>
                                    <p>LKE : {{ $rekap->satker->nama_satker }} akan ditolak dan dilakukan pembinaan</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div> --}}
            @endif
        @endif
    @endif

    <div class="col-lg-4">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-bold mb-3">{{ $rekap->satker->nama_satker }}</span>

                <div class="row">
                    {{-- Self-Assessment --}}
                    <div class="col-lg-6">
                        <span class="info-box-number text-center text-muted mb-3">{{ $nilai_sa }}</span>
                        <span class="info-box-text text-center text-muted mb-0">Nilai Self Assessment</span>
                    </div>
                    {{-- Desk-Evaluation --}}
                    <div class="col-lg-6">
                        @if (auth()->user()->level_id == 'AT')
                            @php
                                $total = $nilai_at;
                            @endphp
                        @elseif(auth()->user()->level_id == 'KT')
                            @php
                                $total = $nilai_kt;
                            @endphp
                        @elseif(auth()->user()->level_id == 'DL')
                            @php
                                $total = $nilai_dl;
                            @endphp
                        @endif
                        <span class="info-box-number text-center text-muted mb-3">{{ $total }}</span>
                        <span class="info-box-text text-center text-muted mb-0">Nilai Desk-Evaluation </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-bold mb-3 text-center">LKE Zona Integritas {{ $rekap->tahun }}</span>
                <div class="row">
                    <div class="col-lg-6">
                        <span class="info-box-text">Total Pengungkit Self-Assessment</span>

                        <div class="progress ">
                            <div class="progress-bar" style="width: {{ $TotprogressSelf }}%"></div>
                        </div>
                        <span class="info-box-number d-flex justify-content-end ">
                            <b class="h5 text-bold">{{ $TotprogressSelf }}%</b>
                        </span>
                    </div>
                    <div class="col-lg-6">
                        {{-- Desk-Evaluation --}}
                        <span class="info-box-text">Total Pengungkit Desk-Evaluation {{ $aktor }}</span>

                        <div class="progress ">
                            <div class="progress-bar" style="width: {{ $TotprogressDesk }}%"></div>
                        </div>
                        <span class="info-box-number d-flex justify-content-end ">
                            <b class="h5 text-bold">{{ $TotprogressDesk }}%</b>
                        </span>
                    </div>
                </div>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    {{-- Rincian Pengungkit --}}
    <b class="mb-3">Rincian Pengungkit</b>
    @foreach ($rincianPengungkit as $value)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <b>SubRincian {{ $value->subRincian }}</b>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($value->pilar as $value)
                                @php
                                    $jumlah_soal = App\Models\Pertanyaan::where('subpilar_id', 'LIKE', '%' . $value->id . '%')->count();
                                    $soal_terjawab = App\Models\selfAssessment::where('pertanyaan_id', 'LIKE', '%' . $value->id . '%')
                                        ->where('rekapitulasi_id', $rekap->id)
                                        ->count(); //mengambil nilai
                                    $progress = round(($soal_terjawab * 100) / $jumlah_soal, 2);
                                @endphp
                                <div class="col-lg-4">
                                    <a href="/tpi/evaluasi/{{ $rekap->id }}/{{ $value->id }}">
                                        @php
                                            if ($progress >= 0 && $progress <= 25) {
                                                $warna = 'orange';
                                            } elseif ($progress >= 25 && $progress <= 50) {
                                                $warna = 'warning';
                                            } elseif ($progress >= 50 && $progress <= 75) {
                                                $warna = 'teal';
                                            } elseif ($progress >= 75 && $progress <= 100) {
                                                $warna = 'success';
                                            }
                                        @endphp
                                        <div class="info-box bg-{{ $warna }}">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-bold mb-3 text-center">
                                                    {{ $value->pilar }}
                                                </span>

                                                @php
                                                    // Ambil Nilai
                                                    $nilai = $value->RekapPengungkit->where('rekapitulasi_id', $rekap->id)->first();
                                                @endphp
                                                <div class="row">
                                                    {{-- Self Assessment --}}
                                                    <div class="col-lg-12">
                                                        <span class="info-box-text  text-bold   text-center">
                                                            Self-Assessment
                                                        </span>
                                                        <span class="info-box-number">
                                                            {{-- Jika nilai ada di database --}}
                                                            @if ($nilai !== null)
                                                                {{ round($nilai->nilai_sa, 2) }}
                                                            @else
                                                                0
                                                            @endif /
                                                            {{ $value->bobot }}
                                                        </span>
                                                        <div class="progress ">
                                                            <div class="progress-bar"
                                                                style="width: {{ $progress }}% ">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <small>Menjawab {{ $soal_terjawab }} dari {{ $jumlah_soal }}
                                                                Soal
                                                            </small>
                                                            <small class="info-box-number">{{ $progress }}%</small>
                                                        </div>
                                                    </div>
                                                    {{-- Desk-Evaluation --}}

                                                    <div class="col-lg-12">
                                                        <span class="info-box-text text-bold  text-center">
                                                            Desk-Evaluation
                                                        </span>
                                                        <span class="info-box-number">
                                                            {{-- Jika nilai ada di database --}}
                                                            @if ($nilai !== null)
                                                                @if (auth()->user()->level_id == 'AT')
                                                                    @php
                                                                        $nilai = $nilai->nilai_at;
                                                                        $soal_terjawab = App\Models\DeskEvaluation::where('id', 'LIKE', '%' . $value->id . '%')
                                                                            ->where('rekapitulasi_id', $rekap->id)
                                                                            ->count('jawaban_at'); //mengambil nilai
                                                                    @endphp
                                                                @elseif(auth()->user()->level_id == 'KT')
                                                                    @php
                                                                        $nilai = $nilai->nilai_kt;
                                                                        $soal_terjawab = App\Models\DeskEvaluation::where('id', 'LIKE', '%' . $value->id . '%')
                                                                            ->where('rekapitulasi_id', $rekap->id)
                                                                            ->count('jawaban_kt'); //mengambil nilai
                                                                    @endphp
                                                                @elseif(auth()->user()->level_id == 'DL')
                                                                    @php
                                                                        $nilai = $nilai->nilai_dl;
                                                                        $soal_terjawab = App\Models\DeskEvaluation::where('id', 'LIKE', '%' . $value->id . '%')
                                                                            ->where('rekapitulasi_id', $rekap->id)
                                                                            ->count('jawaban_dl'); //mengambil nilai
                                                                    @endphp
                                                                @endif
                                                                @php
                                                                    $progress = round(($soal_terjawab * 100) / $jumlah_soal, 2);
                                                                @endphp
                                                                {{ round($nilai, 2) }}
                                                            @else
                                                                0
                                                            @endif /
                                                            {{ $value->bobot }}
                                                        </span>
                                                        <div class="progress ">
                                                            <div class="progress-bar"
                                                                style="width: {{ $progress }}% ">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <small>Menjawab {{ $soal_terjawab }} dari {{ $jumlah_soal }}
                                                                Soal
                                                            </small>
                                                            <small class="info-box-number">{{ $progress }}%</small>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
        </div>
    @endforeach
    <b class="mb-3">Rincian Hasil</b>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        @foreach ($rincianHasil as $value)
                            <div class="col-lg-4">
                                <div class="info-box bg-warning">
                                    <div class="info-box-content" style="height: 150px">
                                        <span class="info-box-number text-bold mb-3 text-center">
                                            {{ $value->pilar }}
                                        </span>
                                        @php
                                            $nilaiHasil = $value->RekapHasil->where('satker_id', $rekap->satker_id)->first();
                                        @endphp
                                        <span class="info-box-number text-center">
                                            {{-- Jika nilai ada di database --}}
                                            Nilai :
                                            @if ($nilaiHasil !== null)
                                                {{ $nilaiHasil->nilai }}
                                            @else
                                                0
                                            @endif /
                                            {{ $value->bobot }}
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                {{-- </a> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <a href="/tpi/evaluasi" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
        Kembali</a>

    {{-- Lihat Perubahan --}}
    <div class="modal fade" id="lihat">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Perubahan Hasil Evaluasi Tahap 1</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @foreach ($rincianPengungkit as $sr)
                        <p>{{ $sr->subRincian }}</p>
                        <table class="table table-bordered table-striped table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th class="text-center" style="width: 50px">Evaluasi AT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sr->pilar as $p)
                                    <tr data-toggle="collapse" data-target="#accordion{{ $p->id }}"
                                        style="background-color: rgb(170, 255, 0)">
                                        <td colspan="2">{{ $p->pilar }}<i class="fa-solid fa-caret-down"></i></td>
                                    </tr>

                                    @foreach ($p->subPilar as $sp)
                                        @foreach ($sp->pertanyaan as $value)
                                            <tr class="collapse" id="accordion{{ substr($value->id, 0, 3) }}">
                                                @php
                                                    $selfAssessment = $value->SelfAssessment->where('rekapitulasi_id', $rekap->id)->first();
                                                @endphp
                                                @if ($selfAssessment)
                                                    @php
                                                        $deskEvaluation = $selfAssessment->DeskEvaluation->first();
                                                    @endphp

                                                    @if ($deskEvaluation != null)
                                                        @if ($selfAssessment->updated_at < $deskEvaluation->created_at)
                                                            {{-- data lama create dan data baru yang  di create tapi ingin tampil --}}
                                                            <td class="">
                                                                <a
                                                                    href="{{ asset('tpi/evaluasi/' . $rekap->id . '/' . $p->id . '#' . $value->id) }}">
                                                                    {{ $value->pertanyaan }}</a>
                                                            </td>
                                                            <td class="text-center ">
                                                                <button class="badge badge-info badge-sm"> <i
                                                                        class="fas fa-check"></i></button>
                                                            </td>
                                                        @endif
                                                        @if ($selfAssessment->updated_at > $deskEvaluation->created_at)
                                                            {{-- Lihat perubahan pada SA --}}
                                                            <td class="">
                                                                <a
                                                                    href="{{ asset('tpi/evaluasi/' . $rekap->id . '/' . $p->id . '#' . $value->id) }}">
                                                                    {{ $value->pertanyaan }}</a>
                                                            </td>
                                                            @if ($selfAssessment->updated_at < $deskEvaluation->updated_at)
                                                                {{-- Jika Deskevaluation telah diperbarui --}}
                                                                <td class="text-center ">
                                                                    <button class="badge badge-info badge-sm"> <i
                                                                            class="fas fa-check"></i></button>
                                                                </td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{-- Jika SA baru create --}}
                                                        <td class="">
                                                            <a
                                                                href="{{ asset('tpi/evaluasi/' . $rekap->id . '/' . $p->id . '#' . $value->id) }}">
                                                                {{ $value->pertanyaan }}</a>
                                                        </td>
                                                        <td></td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach

                            </tbody>

                        </table>
                        {{-- @endforeach
                            @endforeach --}}
                    @endforeach


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
