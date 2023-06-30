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
                            </i> Pengajuan WBK / WBBM</button>
                    </div>
                </div>
            @endif
            <div class="card-body">
                <table id="example1" class="table table-responsive-lg table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Predikat</th>
                            <th>Nilai</th>
                            <th>Surat</th>
                            <th>Informasi</th>
                            <th>LKE</th>
                            <th>Status</th>

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
                                        <button class="badge badge-info"> {{ round($nilai_sa, 2) }}</button>
                                    @else
                                        {{-- Jika data rekappilar belum ada didatabase --}}
                                        0
                                    @endif
                                </td>

                                <td class="text-center">
                                    {{-- Cek Apakah Surat pengantar kabkota sudah diupload/belum --}}
                                    @if ($value->LHE->surat_pengantar_kabkota)
                                        <button type="button" class="btn btn-primary btn-sm " data-toggle="modal"
                                            data-target="#surat_pengantar_kabkota{{ $value->id }}"><i
                                                class="fas fa-file">
                                            </i> Kab/Kota</button>
                                    @endif

                                    {{-- Surat Pengantar Provinsi --}}
                                    @if ($value->LHE->surat_pengantar_prov)
                                        <button type="button" class="btn btn-primary btn-sm " data-toggle="modal"
                                            data-target="#surat_pengantar_prov{{ $value->id }}"><i class="fas fa-file">
                                            </i> Prov</button>
                                    @endif
                                    {{-- Cek Apakah LHE sudah diupload/belum --}}
                                    @if ($value->LHE->LHE_1)
                                        <button type="button" class="btn btn-primary btn-sm " data-toggle="modal"
                                            data-target="#LHE_1{{ $value->id }}"><i class="fas fa-file">
                                            </i> LHE 1</button>
                                    @endif
                                    @if ($value->LHE->LHE_2)
                                        <button type="button" class="btn btn-primary btn-sm " data-toggle="modal"
                                            data-target="#LHE_2{{ $value->id }}"><i class="fas fa-file">
                                            </i> LHE 2</button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- <a type="button" href="/satker/rekapitulasi/{{ $value->id }}"
                                        class="btn btn-sm btn-success"><i class="fa fa-file"></i> Rekap 1</a>
                                    <a type="button" href="/satker/rekap2/{{ $value->id }}"
                                        class="btn btn-sm btn-primary"><i class="fa fa-file"></i> Rekap 2</a>
                                    <a type="button" href="/satker/rekap3/{{ $value->id }}"
                                        class="btn btn-sm btn-warning"><i class="fa fa-file"></i> Rekap 3</a> --}}
                                    <a href="/satker/rekap/{{ $value->id }}" type="button"
                                        class="btn btn-info btn-sm"><i class="fas fa-file"></i> Rekapitulasi</a>
                                    <a href="/satker/catatan/{{ $value->id }}" type="button"
                                        class="btn btn-info btn-sm"><i class="fas fa-file"></i> Catatan</a>
                                </td>
                                <td class="text-center">
                                    <a type="button" href="/satker/lke/{{ $value->id }}"
                                        class="btn btn-sm btn-success"><i class="fa fa-file"></i></a>
                                </td>
                                <td>{{ $value->StatusRekap->status }}
                                    @if ($value->status == 4)
                                        @php
                                            $status_pengawasan = $pengawasan->where('satker_id', $value->satker_id)->first();
                                        @endphp
                                        @if ($status_pengawasan != null)
                                            @if ($status_pengawasan->status == 0)
                                                <button class="badge badge-info">Anggota Tim</button>
                                            @elseif($status_pengawasan->status == 1)
                                                <button class="badge badge-info">Ketua Tim</button>
                                            @else
                                                <button class="badge badge-info">Pengendali Teknis</button>
                                            @endif
                                        @endif
                                    @endif
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
        {{-- Surat Pengantar Kab/kota --}}
        <div class="modal fade" id="surat_pengantar_kabkota{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Surat Pengantar Tahun {{ $value->tahun }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="{{ asset('storage/' . $value->LHE->surat_pengantar_kabkota) }}"
                                allowfullscreen></iframe>
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
        {{-- Surat Pengantar Provinsi --}}
        <div class="modal fade" id="surat_pengantar_prov{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Surat Pengantar Provinsi

                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="{{ asset('storage/' . $value->LHE->surat_pengantar_prov) }}"
                                allowfullscreen></iframe>
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
        {{-- LHE --}}
        <div class="modal fade" id="LHE_1{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Laporan Hasil Evaluasi Tahap 1 Tahun {{ $value->tahun }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ asset('storage/' . $value->LHE->LHE_1) }}"
                                allowfullscreen></iframe>
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
        <div class="modal fade" id="LHE_2{{ $value->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Laporan Hasil Evaluasi Tahap 2 Tahun {{ $value->tahun }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{ asset('storage/' . $value->LHE->LHE_2) }}"
                                allowfullscreen></iframe>
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
