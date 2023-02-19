@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ auth()->user()->satker->nama_satker }}</h3>

                <p class="text-muted text-center">Pengajuan Zona Integritas</p>

                <ul class="list-group list-group-unbordered mb-3">
                    @foreach ($rekap as $value)
                        <li class="list-group-item">
                            <b>{{ $value->satker->nama_satker }}</b> <a class="float-right">{{ $value->predikat }}</a>
                            {{-- Hitung jumlah nilai rincian pengungkit --}}
                            @foreach ($value->RekapPilar as $item)
                                @php
                                    $nilai = $item->where('rekapitulasi_id', $value->id)->sum('nilai');
                                @endphp
                            @endforeach
                            {{-- Hitung jumlah nilai rincian hasil --}}
                            @php
                                $nilaiHasil = App\Models\RekapHasil::where('satker_id', $value->satker_id)
                                    ->where('tahun', date('Y'))
                                    ->get();
                            @endphp
                            @foreach ($nilaiHasil as $item)
                                @php
                                    $nilaiHasil = $item->where('satker_id', $value->satker_id)->sum('nilai');
                                @endphp
                            @endforeach
                            @php
                                $total = $nilai + $nilaiHasil;
                            @endphp
                            Nilai ZI: {{ $total }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">


                <div class="d-flex justify-content-start">
                    <b>{{ auth()->user()->satker->nama_satker }}</b>
                </div>
            </div>
            <div class="card-body">


            </div>


            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
