@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" onclick="exportFile()">
                    <i class="fas fa-download"> Excel</i>
                </button>

            </div>
            <div class="card-body">

                <table id="example2" class="table table-bordered  table-responsive ">
                    <thead>
                        <tr style="background-color:">
                            <th colspan="4">Penilaian</th>
                            <th>Bobot</th>
                            <th>Nilai</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Rincian --}}
                        @foreach ($rincian as $r)
                            <tr>
                                <th>{{ chr(64 + $loop->iteration) }}</th>
                                <th colspan="3">{{ Str::upper($r->rincian) }}</th>
                                <td hidden></td>
                                <td hidden></td>
                                <td class="text-center">{{ $r->bobot }}</td>
                                @php
                                    // Ambil Nilai Pengungkit
                                    $nilai = $nilaiPengungkit->sum('nilai_sa');
                                    $persentase = (round($nilai, 2) * 100) / $r->bobot;
                                @endphp
                                <td class="text-center">{{ round($nilai, 2) }}</td>
                                <td class="text-center">{{ round($persentase, 2) }}%</td>

                            </tr>
                            {{-- Subrincian --}}
                            @foreach ($r->SubRincian as $s)
                                <tr>
                                    <td></td>
                                    <th>{{ $loop->iteration }}</th>
                                    <th colspan="2">{{ Str::upper($s->subRincian) }}</th>
                                    <td hidden></td>

                                    <td class="text-center">{{ $s->bobot }}</td>
                                    @php
                                        // Ambil Nilai
                                        $nilai = App\Models\RekapPengungkit::where('rekapitulasi_id', $rekap->id)
                                            ->where('pilar_id', 'LIKE', '%' . $s->id . '%')
                                            ->sum('nilai_sa');
                                        $persentase = (round($nilai, 2) * 100) / $s->bobot;
                                    @endphp
                                    <td class="text-center">
                                        {{-- Jika nilai ada di database --}}
                                        @if ($nilai !== null)
                                            {{ round($nilai, 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td class="text-center">{{ round($persentase, 2) }}%</td>
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
                                            $nilai = $p->RekapPengungkit->where('rekapitulasi_id', $rekap->id)->sum('nilai_sa');
                                            $persentase = (round($nilai, 2) * 100) / $p->bobot;
                                        @endphp
                                        <td class="text-center">
                                            {{ round($nilai, 2) }}
                                        </td>
                                        <td class="text-center">{{ round($persentase, 2) }}%</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
