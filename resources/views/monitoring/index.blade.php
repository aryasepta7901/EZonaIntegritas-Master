@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>LHE</th>
                            <th>Catatan</th>
                            <th>Satker</th>
                            <th>Nilai Pengungkit</th>
                            <th>Nilai Hasil</th>
                            <th>Mengisi LKE</th>
                            <th>Diusulkan BPS Provinsi</th>
                            <th>Diusulkan BPS Pusat</th>
                            <th>Diusulkan KemenPanRB</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <a href="/monitoring/lhe" type="button" class="btn btn-info btn-sm"><i
                                            class="fas fa-file"></i></a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm"><i class="fas fa-file"></i></button>
                                </td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                <td class="text-center">
                                    @php
                                        $nilai_sa = $nilaiPengungkit->where('rekapitulasi_id', $value->id)->sum('nilai_sa');
                                    @endphp
                                    {{ $nilai_sa }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $nilai = $nilaiHasil->where('satker_id', $value->satker_id)->sum('nilai');
                                    @endphp
                                    {{ $nilai }}
                                </td>
                                {{-- Progress --}}
                                {{-- Mengisi LKE --}}
                                @if ($value->status >= 1)
                                    <td class="text-center text-success text-lg"><i class="fas fa-check"></i></td>
                                    {{-- Proses Pengisian LKE --}}
                                @elseif($value->status == 0)
                                    <td class="text-center text-warning text-lg "><i
                                            class="fas fa-spinner fa-spin-pulse"></i>
                                @endif
                                {{-- Diusulkan BPS Provinsi --}}
                                @if ($value->status > 3)
                                    <td class="text-center text-success text-lg"><i class="fas fa-check"></i></td>
                                    {{-- Proses Penilaian Pendahuluan --}}
                                @elseif($value->status == 1)
                                    <td class="text-center text-warning text-lg "><i
                                            class="fas fa-spinner fa-spin-pulse"></i>
                                    </td>
                                    {{-- Penolakan Provinsi --}}
                                @elseif($value->status == 3)
                                    <td class="text-center text-danger text-lg"><i class="fas fa-xmark"></i></td>
                                @else
                                    <td></td>
                                @endif
                                {{-- Diusulkan BPS Pusat --}}
                                @if ($value->status == 6)
                                    <td class="text-center text-success text-lg"><i class="fas fa-check"></i></td>
                                    {{-- Proses Penilaian TPI --}}
                                @elseif($value->status == 4)
                                    <td class="text-center text-warning text-lg "><i
                                            class="fas fa-spinner fa-spin-pulse"></i>
                                    </td>
                                    {{-- Penolakan TPI --}}
                                @elseif($value->status == 7)
                                    <td class="text-center text-danger text-lg"><i class="fas fa-xmark"></i></td>
                                @else
                                    <td></td>
                                @endif
                                {{-- BPS Pusat --}}
                                {{-- <td class="text-center text-danger text-lg"><i class="fas fa-xmark"></i></td> --}}
                                <td>
                                    Cari Logika ini
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
