@extends('layouts.backEnd.main')

@section('content')
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
                    $tot_soal_terjawab = App\Models\selfAssessment::where('satker_id', auth()->user()->satker_id)->count(); //mengambil nilai
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
                                    $soal_terjawab = App\Models\selfAssessment::where('pertanyaan_id', 'LIKE', '%' . $value->id . '%')->count(); //mengambil nilai
                                    $progress = round(($soal_terjawab * 100) / $jumlah_soal, 2);
                                @endphp
                                <div class="col-lg-4">
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
                                                    <div class="progress-bar" style="width: {{ $progress }}% "></div>
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


    <a href="/lke" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
        Kembali</a>
@endsection
