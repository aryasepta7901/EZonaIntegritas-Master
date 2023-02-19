@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">


                @if ($rekap->count() === 0)
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary  " data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                                Pengajuan WBK / WBBM</i></button>
                    </div>
                @else
                    @php
                        $last = $rekap->last(); //ambil data terakhir
                    @endphp
                    @if ($last->tahun != date('Y'))
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary  " data-toggle="modal" data-target="#tambah"><i
                                    class="fa fa-plus">
                                    Pengajuan WBK / WBBM </i></button>
                        </div>
                    @endif
                @endif




            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Predikat</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Dokumen</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekap as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->tahun }}</td>
                                <td>{{ $value->predikat }}</td>
                                <td>
                                    {{-- Cek apakah data rekappilar ada didatabase --}}

                                    @php
                                        $RekapPilar = $value->RekapPilar->where('rekapitulasi_id', $value->id);
                                    @endphp
                                    @if ($RekapPilar->count() != 0)
                                        {{-- Hitung jumlah nilai rincian pengungkit --}}
                                        @foreach ($RekapPilar as $item)
                                            @php
                                                $nilai = $item->where('rekapitulasi_id', $value->id)->sum('nilai');
                                            @endphp
                                        @endforeach
                                        {{-- Masih Error --}}
                                        {{ $nilai }}
                                    @endif

                                </td>
                                <td>{{ $value->StatusRekap->status }}</td>
                                <td class="text-center">
                                    <a type="button" href="/lke/{{ $value->id }}" class="btn btn-sm btn-success"><i
                                            class="fa fa-file"></i> LKE</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
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
                            <form method="post" action="/lke">
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
                                        <p>Satuan Kerja Anda Berhak mengajukan: <button class="badge badge-sm badge-info">
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
                                <p>Persyaratan Belum Diisi Oleh Admin </p>
                            </div>
                        @endif

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
