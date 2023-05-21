@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        {{-- Session Sukses --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <a href="/prov/surat" class="btn btn-primary"><i class="fa fa-print">
                        </i> Cetak Surat Pengantar</a>
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
                            <th>Surat Pengantar</th>
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
                                <td class="text-center">
                                    {{-- Cek apakah satker sudah melakukan self-assessment --}}
                                    @if ($value->RekapPengungkit->count() != 0)
                                        {{-- Hitung jumlah nilai rincian pengungkit --}}
                                        @foreach ($value->RekapPengungkit as $item)
                                            @php
                                                $nilai_sa = $item->where('rekapitulasi_id', $value->id)->sum('nilai_sa');
                                            @endphp
                                        @endforeach
                                        <button class="badge badge-info">{{ round($nilai_sa, 2) }}</button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Hitung jumlah nilai rincian hasil --}}
                                    @php
                                        $nilai = $nilaiHasil->where('satker_id', $value->satker_id)->sum('nilai');
                                    @endphp
                                    <button class="badge badge-info"> {{ $nilai }} </button>
                                </td>
                                <td class="text-center">
                                    @if ($value->surat_pengantar_kabkota)
                                        <button type="button" class="btn btn-primary btn-sm " data-toggle="modal"
                                            data-target="#surat_pengantar_kabkota{{ $value->id }}"><i
                                                class="fas fa-file">
                                            </i> Kab/Kota</button>
                                    @else
                                        -
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

    {{-- View Surat Pengantar --}}
    {{-- Surat Pengantar kab/kota --}}
    @foreach ($rekap as $value)
        <div class="modal fade" id="surat_pengantar_kabkota{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Surat Pengantar Kab/Kota
                            {{ $value->satker->nama_satker }}({{ $value->tahun }})
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="{{ asset('storage/' . $value->surat_pengantar_kabkota) }}" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="surat_pengantar_prov{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Surat Pengantar
                            {{ $value->satker->nama_satker }}({{ $value->tahun }})-Provinsi
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="{{ asset('storage/' . $value->surat_pengantar_prov) }}" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection