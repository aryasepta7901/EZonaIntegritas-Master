@extends('layouts.backEnd.main')

@section('content')
    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
    @can('pic')
        @if ($rekap->status == 0 || $rekap->status == 2)
            <div class="col-lg-12 mb-3 d-flex justify-content-end">
                <button class="btn btn-primary" data-toggle="modal" data-target="#simpan"><i class="fa fa-save">
                        Kirim LKE</i></button>
            </div>
        @endif
    @endcan
    {{-- Hanya Bisa Diakses Oleh BPS Provinsi --}}
    @can('EvalProv')
        @if ($rekap->status == 1)
            <div class="col-lg-12 mb-3 d-flex justify-content-end">
                <button class="btn btn-success m-2" data-toggle="modal" data-target="#setuju"><i class="fa fa-save">
                        Setuju</i></button>
                <button class="btn btn-warning m-2" data-toggle="modal" data-target="#revisi"><i class="fa fa-save">
                        Revisi</i></button>
                <button class="btn btn-danger m-2" data-toggle="modal" data-target="#tolak"><i class="fa fa-save">
                        Tolak</i></button>
            </div>
        @endif
    @endcan
    <div class="col-lg-4">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-bold mb-3">{{ $rekap->satker->nama_satker }}</span>
                <span class="info-box-number text-center text-muted mb-3">{{ $nilai }}</span>
                <span class="info-box-text text-center text-muted mb-0">Nilai Self-Assessment</span>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-bold mb-3">LKE Zona Integritas {{ $rekap->tahun }}</span>
                <span class="info-box-text">Total Pengungkit</span>
                @php
                    $tot_jumlah_soal = App\Models\Pertanyaan::count();
                    $tot_soal_terjawab = App\Models\selfAssessment::where('rekapitulasi_id', $rekap->id)->count(); //mengambil nilai
                    $Totprogress = round(($tot_soal_terjawab * 100) / $tot_jumlah_soal, 2);
                    
                @endphp

                <div class="progress ">
                    <div class="progress-bar" style="width: {{ $Totprogress }}%"></div>
                </div>
                <span class="info-box-number d-flex justify-content-end ">
                    <b class="h5 text-bold">{{ $Totprogress }}%</b>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
    <b class="mb-3">Rincian Pengungkit</b>
    @foreach ($subrincian as $value)
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
                                    {{-- Jika Evaluator Prov Koreksi --}}
                                    @can('EvalProv')
                                        <a href="/prov/evaluasi/{{ $rekap->id }}/{{ $value->id }}">
                                            <div class="info-box bg-warning">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-bold mb-3 text-center">

                                                        {{ wordwrap($value->pilar, '15', "\n") }}
                                                    </span>

                                                    @php
                                                        // Ambil Nilai
                                                        $nilai = App\Models\RekapPilar::where('rekapitulasi_id', $rekap->id)
                                                            ->where('pilar_id', $value->id)
                                                            ->first();
                                                    @endphp
                                                    <span class="info-box-number">
                                                        {{-- Jika nilai ada di database --}}
                                                        @if ($nilai !== null)
                                                            {{ $nilai->nilai }}
                                                        @else
                                                            0
                                                        @endif /
                                                        {{ $value->bobot }}
                                                    </span>
                                                    <div class="progress ">
                                                        <div class="progress-bar" style="width: {{ $progress }}% ">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <small>Menjawab {{ $soal_terjawab }} dari {{ $jumlah_soal }} Soal
                                                        </small>
                                                        <small class="info-box-number">{{ $progress }}%</small>
                                                    </div>


                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                        </a>
                                    @endcan
                                    {{-- Jika PIC sedang self --}}
                                    @can('pic')
                                        <a href="/lke/{{ $rekap->id }}/{{ $value->id }}">
                                            <div class="info-box bg-warning">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-bold mb-3 text-center">

                                                        {{ wordwrap($value->pilar, '15', "\n") }}
                                                    </span>

                                                    @php
                                                        // Ambil Nilai
                                                        $nilai = App\Models\RekapPilar::where('rekapitulasi_id', $rekap->id)
                                                            ->where('pilar_id', $value->id)
                                                            ->first();
                                                    @endphp
                                                    <span class="info-box-number">
                                                        {{-- Jika nilai ada di database --}}
                                                        @if ($nilai !== null)
                                                            {{ $nilai->nilai }}
                                                        @else
                                                            0
                                                        @endif /
                                                        {{ $value->bobot }}
                                                    </span>
                                                    <div class="progress ">
                                                        <div class="progress-bar" style="width: {{ $progress }}% ">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <small>Menjawab {{ $soal_terjawab }} dari {{ $jumlah_soal }} Soal
                                                        </small>
                                                        <small class="info-box-number">{{ $progress }}%</small>
                                                    </div>


                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                        </a>
                                    @endcan

                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    @endforeach
    {{-- Jika yang akses Tim Evaluator Provinsi --}}
    @can('EvalProv')
        <a href="/prov/evaluasi" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
            Kembali</a>
    @endcan
    {{-- Jika yang akses  PIC --}}
    @can('pic')
        <a href="/lke" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
            Kembali</a>
    @endcan


    {{-- Kirim LKE --}}
    <div class="modal fade" id="simpan">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apakah Kamu Yakin untuk Mengirim LKE?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/lke/{{ $rekap->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $rekap->id }}">

                        <p> <b> Note:</b> <br></p>
                        <p>Harap Periksa Kembali Isian anda , apakah sudah lengkap atau tidak , jika LKE
                            sudah dikirim maka
                            tidak akan bisa diisi kembali. LKE akan dikirim dan di cek oleh validator Provinsi</p>


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
                        <input type="hidden" name="status" value="4">
                        <p> <b> Note:</b> <br></p>
                        <p>LKE yang telah disetujui akan dikirimkan ke TPI Inspektorat Utama</p>


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

    {{-- Revisi LKE --}}
    <div class="modal fade" id="revisi">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apakah Kamu Yakin untuk Mengirimkan Kembali LKE?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/prov/evaluasi/{{ $rekap->id }}">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $rekap->id }}">
                        <input type="hidden" name="status" value="1">
                        <p> <b> Note:</b> <br></p>
                        <p>LKE akan dikembalikan ke {{ $rekap->satker->nama_satker }} untuk diperbaiki kembali</p>
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

    {{-- Tolak LKE --}}
    <div class="modal fade" id="tolak">
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
                        <input type="hidden" name="status" value="3">
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
    </div>
@endsection
