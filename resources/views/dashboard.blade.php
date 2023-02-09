@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <p class="text-center">Selamat Datang Kembali {{ auth()->user()->name }}
                    ({{ auth()->user()->satker->nama_satker }})
                </p>

                @can('pic')
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary  " data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                                Pengajuan WBK / WBBM</i></button>
                    </div>
                @endcan
            </div>
            <div class="card-body">
                @can('pic')
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
                            <tbody></tbody>

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

                                <form method="post" action="/users">
                                    @csrf
                                    <div class="modal-body">
                                        @if ($persyaratan->wbbm == 1)
                                            <p>Satuan Kerja Anda Berhak mengajukan <button
                                                    class="badge badge-sm badge-info">Wilayah
                                                    Birokrasi Bersih dan Melayani</button>
                                            </p>
                                        @else
                                            <p>Satuan Kerja Anda Berhak mengajukan <button
                                                    class="badge badge-sm  badge-info">Wilayah Bebas
                                                    dari Korupsi</button>
                                            </p>
                                        @endif
                                        <small>Note: Silahkan Klik Lanjutkan untuk membuka LKE</small>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                @endcan
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
