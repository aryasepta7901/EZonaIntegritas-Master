@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Ada Kesalahan</h5>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                    <br>
                @endforeach
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
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
                            <th>LKE</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ambil data pengawasan TPI --}}
                        @if (auth()->user()->level_id == 'AT')
                            @php
                                $data = $anggota->pengawasan;
                            @endphp
                        @elseif(auth()->user()->level_id == 'KT')
                            @php
                                $tpi = $ketua->id;
                                $data = $pengawasan->where('tpi_id', $tpi);
                            @endphp
                        @elseif(auth()->user()->level_id == 'DL')
                            @foreach ($dalnis as $d)
                                @php
                                    $tpi[] = $d->id;
                                    
                                    $data = $pengawasan->whereIn('tpi_id', $tpi);
                                    
                                @endphp
                            @endforeach
                        @endif
                        @foreach ($data as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                {{-- Cek apakah satker sudah mengajukan ZI --}}
                                @if ($value->rekapitulasi->count() != 0)
                                    @foreach ($value->rekapitulasi as $item)
                                        <td>{{ $item->predikat }}</td>
                                        <td>
                                            {{-- Hitung jumlah nilai rincian pengungkit --}}
                                            @if ($item->RekapPengungkit->count() != 0)
                                                @foreach ($item->RekapPengungkit as $P)
                                                    @php
                                                        $nilai_sa = $P->where('rekapitulasi_id', $item->id)->sum('nilai_sa');
                                                    @endphp
                                                @endforeach
                                                {{ $nilai_sa }}
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Hitung jumlah nilai rincian hasil --}}
                                            @php
                                                $nilai = $nilaiHasil->where('satker_id', $item->satker_id)->sum('nilai');
                                            @endphp

                                            {{ $nilai }}
                                        </td>

                                        {{-- Cek Apakah Surat Rekomendasi ada --}}
                                        @if ($item->surat_pengantar_prov != '')
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#surat_pengantar_prov{{ $item->satker_id }}"><i
                                                        class="fas fa-file">
                                                    </i></button>
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <button class="btn btn-info btn-sm">No Dokumen</button>
                                            </td>
                                        @endif

                                        <td class="text-center">
                                            <a type="button" href="/tpi/evaluasi/{{ $item->id }}"
                                                class="btn btn-sm btn-success"><i class="fa fa-file"></i> LKE</a>
                                        </td>

                                        <td>{{ $item->StatusRekap->status }}</td>

                                        {{-- View Surat Pengantar --}}
                                        <div class="modal fade" id="surat_pengantar_prov{{ $item->satker_id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Surat Pengantar
                                                            {{ $item->satker->nama_satker }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item"
                                                                src="{{ asset('storage/' . $item->surat_pengantar_prov) }}"
                                                                allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @endforeach
                                @else
                                    <td colspan="6" class="text-center"><button class="btn btn-info">Satker Belum
                                            Mengajukan Zona Integritas </button></td>
                                @endif
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
