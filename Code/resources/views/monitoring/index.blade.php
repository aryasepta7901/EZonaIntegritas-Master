@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="width: 200px">Satker</th>
                            <th>Tahun</th>
                            <th>Predikat</th>
                            <th>LHE</th>
                            <th>Catatan</th>
                            <th>Nilai Pengungkit</th>
                            <th>Nilai Hasil</th>
                            <th>Mengisi LKE</th>
                            <th>Diusulkan BPS Provinsi</th>
                            <th>Diusulkan BPS Pusat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                <td>{{ $value->tahun }}</td>
                                <td>{{ $value->predikat }}</td>
                                <td class="text-center">
                                    <a href="/monitoring/lhe/{{ $value->id }}" type="button" class="btn btn-info btn-sm"><i
                                            class="fas fa-file"></i></a>
                                </td>

                                <td class="text-center">
                                    <a href="/monitoring/catatan/{{ $value->id }}" type="button"
                                        class="btn btn-info btn-sm"><i class="fas fa-file"></i></a>
                                </td>
                                <td class="text-center">
                                    @php
                                        $nilai_sa = $nilaiPengungkit->where('rekapitulasi_id', $value->id)->sum('nilai_sa');
                                    @endphp
                                    {{ $nilai_sa }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $nilai = $nilaiHasil
                                            ->where('tahun', $value->tahun)
                                            ->where('satker_id', $value->satker_id)
                                            ->sum('nilai');
                                    @endphp
                                    {{ $nilai }}
                                </td>
                                {{-- Progress --}}
                                {{-- Mengisi LKE --}}
                                @if ($value->status >= 1)
                                    <td class="text-center text-success text-lg"><i class="fas fa-check"></i>
                                        @if ($value->status == 5)
                                            <button class="badge badge-info">Tindak Lanjut TPI</button>
                                        @endif
                                    </td>
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
                                <td> <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $value->id }}"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    {{-- Hapus --}}
    @foreach ($rekap as $value)
        <div class="modal fade" id="hapus{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Data Rekap:</p>
                        <b>{{ $value->satker->nama_satker }}
                            ?</b>
                    </div>
                    <form action="/monitoring/{{ $value->id }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection
