@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between ">
                <b>{{ $rekap->satker->nama_satker }}</b>
                <button class="btn btn-primary ml-auto" onclick="exportFile()">
                    <i class="fas fa-download"> </i> Excel
                </button>
            </div>

            <div class="card-body">

                <table id="excel" class="table table-bordered  table-responsive ">
                    <thead>
                        <tr style="background-color:">
                            <th colspan="4">Penilaian</th>
                            <th>Bobot</th>
                            <th class="text-center">Self Assessment</th>
                            <th class="text-center">Evaluasi AT</th>
                            <th class="text-center">Evaluasi KT</th>
                            <th class="text-center">Evaluasi DL</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Rincian --}}
                        @foreach ($rincianPengungkit as $r)
                            <tr>
                                <th>{{ chr(64 + $loop->iteration) }}</th>
                                <th colspan="3">{{ Str::upper($r->rincian) }}</th>
                                <th class="text-center">{{ $r->bobot }}</th>
                                @php
                                    // Ambil Nilai Pengungkit
                                    $nilaiPengungkit_sa = $nilaiPengungkit->sum('nilai_sa');
                                    $nilaiPengungkit_at = $nilaiPengungkit->sum('nilai_at');
                                    $nilaiPengungkit_kt = $nilaiPengungkit->sum('nilai_kt');
                                    $nilaiPengungkit_dl = $nilaiPengungkit->sum('nilai_dl');
                                @endphp
                                <th class="text-center">{{ round($nilaiPengungkit_sa, 2) }}</th>
                                <th class="text-center">{{ round($nilaiPengungkit_at, 2) }}</th>
                                <th class="text-center">{{ round($nilaiPengungkit_kt, 2) }}</th>
                                <th class="text-center">{{ round($nilaiPengungkit_dl, 2) }}</th>

                            </tr>
                            {{-- Subrincian --}}
                            @foreach ($r->SubRincian as $s)
                                <tr>
                                    <td></td>
                                    <th>{{ $loop->iteration }}</th>
                                    <th colspan="2">{{ Str::upper($s->subRincian) }}</th>
                                    <th class="text-center">{{ $s->bobot }}</th>
                                    @php
                                        // Ambil Nilai
                                        $RekapPengungkit = App\Models\RekapPengungkit::where('rekapitulasi_id', $rekap->id)->where('pilar_id', 'LIKE', '%' . $s->id . '%');
                                        $nilai_sa = $RekapPengungkit->sum('nilai_sa');
                                        $nilai_at = $RekapPengungkit->sum('nilai_at');
                                        $nilai_kt = $RekapPengungkit->sum('nilai_kt');
                                        $nilai_dl = $RekapPengungkit->sum('nilai_dl');
                                    @endphp
                                    <th class="text-center"> {{ round($nilai_sa, 2) }}
                                    </th>
                                    <th class="text-center"> {{ round($nilai_at, 2) }}</th>
                                    <th class="text-center"> {{ round($nilai_kt, 2) }}</th>
                                    <th class="text-center"> {{ round($nilai_dl, 2) }}</th>
                                </tr>
                                {{-- Pilar --}}
                                @foreach ($s->Pilar as $p)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::upper($p->pilar) }}</td>
                                        <td class="text-center">{{ $p->bobot }}</td>
                                        @php
                                            // Ambil Nilai Pengungkit
                                            $RekapPengungkit = $p->RekapPengungkit->where('rekapitulasi_id', $rekap->id);
                                            $nilai_sa = $RekapPengungkit->sum('nilai_sa');
                                            $nilai_at = $RekapPengungkit->sum('nilai_at');
                                            $nilai_kt = $RekapPengungkit->sum('nilai_kt');
                                            $nilai_dl = $RekapPengungkit->sum('nilai_dl');
                                        @endphp
                                        <td class="text-center">{{ round($nilai_sa, 2) }} </td>
                                        <td class="text-center">{{ round($nilai_at, 2) }} </td>
                                        <td class="text-center">{{ round($nilai_kt, 2) }} </td>
                                        <td class="text-center">{{ round($nilai_dl, 2) }} </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach

                        @foreach ($rincianHasil as $r)
                            <tr>
                                <th>{{ chr(65 + $loop->iteration) }}</th>
                                <th colspan="3">{{ Str::upper($r->rincian) }}</th>
                                <th class="text-center">{{ $r->bobot }}</th>
                                @php
                                    // Ambil Nilai Hasil
                                    $nilaiHasil = $nilaiHasil->sum('nilai');
                                    $persentase = (round($nilaiHasil, 2) * 100) / $r->bobot;
                                @endphp
                                <th class="text-center" colspan="4">{{ round($nilaiHasil, 2) }}</th>
                            </tr>
                            {{-- Subrincian --}}
                            @foreach ($r->SubRincian as $s)
                                <tr>
                                    <td></td>
                                    <th>{{ $loop->iteration }}</th>
                                    <th colspan="2">{{ Str::upper($s->subRincian) }}</th>
                                    <th class="text-center">{{ $s->bobot }}</th>
                                    @php
                                        // Ambil Nilai
                                        // $nilai = $nilaiHasil->where('pilar_id', 'LIKE', '%' . $s->id . '%')->sum('nilai');
                                        $nilai = App\Models\RekapHasil::where('satker_id', $rekap->satker_id)
                                            ->where('pilar_id', 'LIKE', '%' . $s->id . '%')
                                            ->sum('nilai');
                                    @endphp
                                    <th class="text-center" colspan="4">{{ round($nilai, 2) }}</th>
                                </tr>
                                {{-- Pilar --}}
                                @foreach ($s->Pilar as $p)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ Str::upper($p->pilar) }}</td>
                                        <td class="text-center">{{ $p->bobot }}</td>
                                        @php
                                            // Ambil Nilai Pengungkit
                                            $nilai = $p->RekapHasil->where('satker_id', $rekap->satker_id)->sum('nilai');
                                        @endphp
                                        <td class="text-center" colspan="4">
                                            {{ round($nilai, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                        <tr>
                            <th colspan="4">NILAI EVALUASI REFORMASI BIROKRASI</th>
                            <th class="text-center">100</th>
                            @php
                                $total = $nilaiPengungkit_sa + $nilaiHasil;
                            @endphp
                            <th class="text-center" colspan="4">{{ $total }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
