@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-4">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-bold mb-3">{{ $rekap->satker->nama_satker }}</span>
                <span class="info-box-number text-center text-muted mb-3">2300</span>
                <span class="info-box-text text-center text-muted mb-0">Nilai Self-Assessment</span>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-bold mb-3">LKE Zona Integritas {{ $rekap->tahun }}</span>
                <span class="info-box-text">Total Pengungkit</span>

                <div class="progress ">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="info-box-number d-flex justify-content-end ">
                    <b class="h5 text-bold">20</b>/60
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
                            @php
                                $pilar = App\Models\Pilar::where('subrincian_id', $value->id)->get();
                                
                            @endphp

                            @foreach ($pilar as $value)
                                @php
                                    $jumlah_soal = App\Models\Pertanyaan::where('subpilar_id', 'LIKE', '%' . $value->id . '%')->count();
                                    
                                @endphp
                                <div class="col-lg-4">
                                    <div class="info-box bg-warning">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-bold mb-3 text-center">
                                                {{-- @php
                                                    $chunk_size = 30;
                                                    $total_chunks = ceil(strlen($value->pilar) / $chunk_size);
                                                    for ($i = 0; $i < $total_chunks; $i++) {
                                                        $offset = $i * $chunk_size;
                                                        $chunk = substr($value->pilar, $offset, $chunk_size);
                                                        echo $chunk . '<br>';
                                                    }
                                                @endphp --}}
                                                {{ wordwrap($value->pilar, '15', "\n") }}
                                                ({{ $jumlah_soal }})
                                            </span>
                                            <span class="info-box-number">0/ {{ $value->bobot }}</span>

                                            <div class="progress ">
                                                <div class="progress-bar" style="width: 70%"></div>
                                            </div>
                                            <small>Menjawab 2 dari {{ $jumlah_soal }} Soal</small>
                                            <span class="info-box-number d-flex justify-content-end ">
                                                <b class="h5 text-bold">20</b>/60
                                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
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
@endsection
