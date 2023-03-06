@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <a href="/prov/surat" class="btn btn-primary"><i class="fa fa-print">
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
                                    {{-- Cek apakah satker sudah melakukan self-assessment --}}
                                    @if ($value->RekapPengungkit->count() != 0)
                                        {{-- Hitung jumlah nilai rincian pengungkit --}}
                                        @foreach ($value->RekapPengungkit as $item)
                                            @php
                                                $nilaiRekap = $item->where('rekapitulasi_id', $value->id)->get();
                                                $nilai_sa = 0;
                                            @endphp
                                            @foreach ($nilaiRekap as $n)
                                                @php
                                                    $nilai_sa += round($n->nilai_sa, 2);
                                                @endphp
                                            @endforeach
                                        @endforeach
                                        {{ $nilai_sa }}
                                    @endif
                                </td>
                                <td>
                                    {{-- Hitung jumlah nilai rincian hasil --}}
                                    @php
                                        $nilai = $nilaiHasil->where('satker_id', $value->satker_id);
                                    @endphp
                                    {{-- Jika Rincian Hasil sudah diupload oleh Admin --}}
                                    @if ($nilai->count() != 0)
                                        @foreach ($nilai as $item)
                                            @php
                                                $nilai = $item->where('satker_id', $value->satker_id)->sum('nilai');
                                            @endphp
                                        @endforeach
                                        {{ $nilai }}
                                    @else
                                        {{-- Jika Rincian Hasil belum diupload oleh admin --}}
                                        @php
                                            $nilai = 0;
                                        @endphp
                                        {{ $nilai }} (Data Nilai Hasil Belum di Upload Inspektorat Utama)
                                    @endif
                                </td>
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
