@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">


                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary  " data-toggle="modal" data-target="#tambah"><i class="fa fa-print">
                            Cetak Surat Persetujuan</i></button>
                </div>
            </div>
            <div class="card-body">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kabupaten/Kota</th>
                            <th>Predikat</th>
                            <th>Nilai</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                <td>{{ $value->predikat }}</td>
                                <td>
                                    {{-- Hitung jumlah nilai rincian pengungkit --}}
                                    @foreach ($value->RekapPilar as $item)
                                        @php
                                            $nilai = $item->sum('nilai');
                                        @endphp
                                    @endforeach
                                    {{ $nilai }}
                                </td>
                                <td class="text-center"><button class="btn btn-sm btn-info"><i
                                            class="fas fa-file"></i></button>
                                </td>
                                <td>{{ $value->status }}</td>
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
