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
            @php
                $last = $rekap->last(); //ambil data tahun terakhir
            @endphp
            {{-- hanya bisa diakses jika data pertama kali dibuat atau  data rekap berbeda tahun dengan yang ada di database  --}}
            @if ($rekap->count() == 0 || $last->tahun != date('Y'))
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary  " data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                                Pengajuan WBK / WBBM</i></button>
                    </div>
                </div>
            @endif
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Predikat</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Surat Pengantar</th>
                            <th>Dokumen</th>
                            <th>Informasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->tahun }}</td>
                                <td>{{ $value->predikat }}</td>
                                <td class="text-center">
                                    {{-- Cek apakah data rekappilar ada didatabase --}}
                                    @if ($value->RekapPengungkit->count() != 0)
                                        {{-- Hitung jumlah nilai rincian pengungkit --}}
                                        @foreach ($value->RekapPengungkit as $item)
                                            @php
                                                $nilai_sa = $item->where('rekapitulasi_id', $value->id)->sum('nilai_sa');
                                            @endphp
                                        @endforeach
                                        {{ round($nilai_sa, 2) }}
                                    @else
                                        {{-- Jika data rekappilar belum ada didatabase --}}
                                        0
                                    @endif
                                </td>
                                <td>{{ $value->StatusRekap->status }}</td>
                                <td class="text-center">
                                    {{-- Cek Apakah Surat pengantar kabkota sudah diupload/belum --}}
                                    @if ($value->surat_pengantar_kabkota)
                                        <button type="button" class="btn btn-info btn-sm " data-toggle="modal"
                                            data-target="#surat_pengantar_kabkota{{ $value->id }}"><i
                                                class="fas fa-file">
                                            </i> Kab/Kota</button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a type="button" href="/satker/lke/{{ $value->id }}"
                                        class="btn btn-sm btn-success"><i class="fa fa-file"></i> LKE</a>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="/satker/rekapitulasi/{{ $value->id }}"
                                        class="btn btn-sm btn-success"><i class="fa fa-file"></i> Rekap 1</a>
                                    <a type="button" href="/satker/rekap2/{{ $value->id }}"
                                        class="btn btn-sm btn-primary"><i class="fa fa-file"></i> Rekap 2</a>
                                    <a type="button" href="/satker/rekap3/{{ $value->id }}"
                                        class="btn btn-sm btn-warning"><i class="fa fa-file"></i> Rekap 3</a>
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

    {{-- Tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pengajuan WBK/WBBM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- Cek apakah persyaratan sudah diisi oleh admin atau tidak --}}
                @if ($persyaratan)
                    <form method="post" action="/satker/lke">
                        @csrf
                        <input type="hidden" name="satker_id" value="{{ auth()->user()->satker_id }}">
                        @if ($persyaratan->wbbm == 1)
                            @php
                                $nilai = 'WBBM';
                            @endphp
                        @elseif($persyaratan->wbk == 1)
                            @php
                                $nilai = 'WBK';
                            @endphp
                        @endif

                        @isset($nilai)
                            <input type="hidden" name="predikat" value="{{ $nilai }}">
                        @endisset
                        <div class="modal-body">

                            @if ($persyaratan->wbk == 1 || $persyaratan->wbbm == 1)
                                <p>Satuan Kerja Anda Berhak mengajukan: <button type="button"
                                        class="badge badge-sm badge-info">
                                        @if ($persyaratan->wbbm == 1)
                                            Wilayah Birokrasi Bersih dan Melayani
                                        @else
                                            Wilayah Bebas dari Korupsi
                                        @endif
                                    </button>
                                </p>
                                <small>Note: Silahkan Klik Lanjutkan untuk membuka LKE</small>
                            @else
                                <p class="text-danger text-center">{{ $persyaratan->satker->nama_satker }} Belum
                                    Memenuhi dalam
                                    pengajuan WBK/WBBM </p>
                            @endif
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            @if ($persyaratan->wbk != 0 || $persyaratan->wbbm != 0)
                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                            @endif
                        </div>
                    </form>
                @else
                    {{-- Jika Persyaratan belum diisi oleh admin --}}
                    <div class="modal-body">
                        <p class="text-info">Persyaratan Belum Diisi Oleh Admin, Silahkan Hubungi Inspektorat Utama untuk
                            mendapatkan akses terhadap LKE</p>
                    </div>
                @endif

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- View Surat --}}
    @foreach ($rekap as $value)
        <div class="modal fade" id="surat_pengantar_kabkota{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Surat Pengantar {{ $value->tahun }}
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
    @endforeach


@endsection
