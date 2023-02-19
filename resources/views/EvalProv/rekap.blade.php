@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">


                <div class="d-flex justify-content-end">
                    <a href="/evaluasi/prov/cetak/" class="btn btn-primary  "><i class="fa fa-print">
                            Cetak Surat Persetujuan</i></a>
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
                                            $nilai = $item->where('rekapitulasi_id', $value->id)->sum('nilai');
                                        @endphp
                                    @endforeach
                                    {{ $nilai }}
                                </td>
                                <td class="text-center">
                                    <a type="button" href="/evaluasi/prov/{{ $value->id }}"
                                        class="btn btn-sm btn-success"><i class="fa fa-file"></i> LKE</a>
                                </td>
                                </td>
                                <td>{{ $value->StatusRekap->status }}</td>
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
