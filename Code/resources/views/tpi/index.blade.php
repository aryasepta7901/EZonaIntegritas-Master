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
                            <th>Nilai </th>
                            <th>Surat</th>
                            <th>Rekap</th>
                            <th>LKE</th>
                            <th>Status</th>
                            <th>Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ambil data pengawasan TPI --}}
                        @if (auth()->user()->level_id == 'AT')
                            @if ($anggota != null)
                                @php
                                    $data = $anggota->pengawasan;
                                @endphp
                            @else
                                @php
                                    $data = null;
                                @endphp
                            @endif
                        @elseif(auth()->user()->level_id == 'KT')
                            @if ($ketua != null)
                                @php
                                    $tpi = $ketua->id; //ambil id_ketua
                                    $data = $pengawasan->where('tpi_id', $tpi);
                                @endphp
                            @else
                                @php
                                    $data = null;
                                @endphp
                            @endif
                        @elseif(auth()->user()->level_id == 'DL')
                            @if ($dalnis != null)
                                @foreach ($dalnis as $d)
                                    @php
                                        $tpi[] = $d->id; //ambil id_dalnis
                                        $data = $pengawasan->whereIn('tpi_id', $tpi);
                                        
                                    @endphp
                                @endforeach
                            @else
                                @php
                                    $data = null;
                                @endphp
                            @endif
                        @endif
                        @if ($data != null)
                            @foreach ($data as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->satker->nama_satker }}</td>
                                    {{-- Cek apakah satker sudah mengajukan ZI --}}
                                    @if ($value->rekapitulasi->count() != 0)
                                        @foreach ($value->rekapitulasi as $item)
                                            <td>{{ $item->predikat }}</td>
                                            <td class="text-center">
                                                {{-- Hitung jumlah nilai rincian pengungkit --}}
                                                @if ($item->RekapPengungkit->count() != 0)
                                                    @foreach ($item->RekapPengungkit as $P)
                                                        @php
                                                            $nilai_sa = $P->where('rekapitulasi_id', $item->id)->sum('nilai_sa');
                                                        @endphp
                                                    @endforeach
                                                    <button class="badge badge-info">{{ round($nilai_sa, 2) }}</button>
                                                @endif
                                            </td>

                                            <td class="text-center">

                                                {{-- Cek Apakah Surat Rekomendasi ada --}}
                                                @if ($item->LHE->surat_pengantar_prov != '')
                                                    <button class="btn btn-primary btn-sm m-1" data-toggle="modal"
                                                        data-target="#surat_pengantar_prov{{ $item->satker_id }}"><i
                                                            class="fas fa-file">
                                                        </i> Prov</button>
                                                @endif
                                                @if ($item->LHE->LHE_1)
                                                    <button type="button" class="btn btn-primary btn-sm m-1 "
                                                        data-toggle="modal" data-target="#LHE_1{{ $item->satker_id }}"><i
                                                            class="fas fa-file">
                                                        </i> LHE 1</button>
                                                @endif
                                                @if ($item->LHE->LHE_2)
                                                    <button type="button" class="btn btn-primary btn-sm "
                                                        data-toggle="modal" data-target="#LHE_2{{ $item->satker_id }}"><i
                                                            class="fas fa-file">
                                                        </i> LHE 2</button>
                                                @endif
                                            </td>

                                            <td class="text-center">

                                                <a href="/tpi/rekap/{{ $item->id }}" type="button"
                                                    class="btn btn-info btn-sm"><i class="fas fa-file"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <a type="button" href="/tpi/evaluasi/{{ $item->id }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-file"></i> </a>
                                            </td>
                                            <td>{{ $item->StatusRekap->status }}
                                                @if ($item->status == 4)
                                                    @php
                                                        $status_pengawasan = $pengawasan->where('satker_id', $value->satker_id)->first();
                                                    @endphp
                                                    @if ($status_pengawasan->status == 0)
                                                        <button class="badge badge-info">Anggota Tim</button>
                                                    @elseif($status_pengawasan->status == 1)
                                                        <button class="badge badge-info">Ketua Tim</button>
                                                    @else
                                                        <button class="badge badge-info">Pengendali Teknis</button>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <p class="badge badge-sm badge-info">Tahap {{ $value->tahap }}</p>
                                            </td>
                                            {{-- View Surat Pengantar --}}
                                            <div class="modal fade" id="surat_pengantar_prov{{ $item->satker_id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Surat Pengantar
                                                                @php
                                                                    $prov = substr($item->satker_id, 0, 3) . '0';
                                                                    $satker = $satker->where('id', $prov)->first();
                                                                @endphp
                                                                {{ $satker->nama_satker }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <iframe class="embed-responsive-item"
                                                                    src="{{ asset('storage/' . $item->LHE->surat_pengantar_prov) }}"
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
                                            {{-- LHE --}}
                                            <div class="modal fade" id="LHE_1{{ $item->satker_id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Laporan Hasil Evaluasi Tahap 1 Tahun
                                                                {{ $item->tahun }}
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <iframe class="embed-responsive-item"
                                                                    src="{{ asset('storage/' . $item->LHE->LHE_1) }}"
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
                                            <div class="modal fade" id="LHE_2{{ $item->satker_id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Laporan Hasil Evaluasi Tahap 2 Tahun
                                                                {{ $item->tahun }}
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <iframe class="embed-responsive-item"
                                                                    src="{{ asset('storage/' . $item->LHE->LHE_2) }}"
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
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><button class="btn btn-danger btn-sm"> Belum
                                                Mengajukan </button></td>
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
