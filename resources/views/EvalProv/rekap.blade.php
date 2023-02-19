@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">


                <div class="d-flex justify-content-end">
                    <a href="/prov/surat" class="btn btn-primary  "><i class="fa fa-print">
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
                            <th>Nilai Pengungkit</th>
                            <th>Nilai Hasil</th>
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
                                <td>
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
                                    {{ $nilaiHasil }}
                                </td>
                                @php
                                    $total = $nilai + $nilaiHasil;
                                @endphp



                                <td class="text-center">
                                    <a type="button" href="/prov/evaluasi/{{ $value->id }}"
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
