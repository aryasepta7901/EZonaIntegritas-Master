@extends('layouts.backEnd.main')

@section('content')

    <div class="col-lg-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $tpi->nama }}</h3>

                <p class="text-muted text-center">Wilayah {{ $tpi->wilayah }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Dalnis</b> <a class="float-right">{{ $tpi->user->name }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Ketua Tim</b> <a class="float-right">{{ $tpi->ketua->name }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Anggota</b>
                        <ul>
                            @foreach ($tpi->anggota as $a)
                                <li>{{ $a->user->name }}</li> : <button class="badge badge-info">
                                    @php
                                        $jumlah_satker = $a->pengawasan->count();
                                    @endphp
                                    {{ $jumlah_satker }}
                                </button>

                                Pengawasan
                            @endforeach
                        </ul>
                    </li>
                </ul>

            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-lg-9">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Ada Kesalahan</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li> {{ $error }}</li>
                    @endforeach
                </ul>
                <small class="badge badge-info"> <i class="icon fas fa-info"></i> Note : Silahkan Buka Kembali Pop Up untuk
                    melakukan perubahan pada isian yang
                    salah</small>
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
            <!-- /.card-header -->
            <div class="card-header d-flex justify-content-end">

                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                    </i>Tambah
                    Pengawasan </button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Anggota </th>
                            <th>Satker</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengawasan as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->anggota->name }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $value->id }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>


    {{-- Tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pengawasan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/pengawasan">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tpi_id" value="{{ $tpi->id }}">
                        <div class="form-group">
                            <label class="@error('anggota_id') text-danger  @enderror" for="anggota_id">Anggota</label>
                            @error('anggota_id')
                                <small class="badge badge-danger"> *{{ $message }}
                                </small>
                            @enderror
                            <select class="form-control select2bs4" name="anggota_id">
                                <option value="">Pilih Anggota</option>

                                @foreach ($tpi->anggota as $a)
                                    @if (old('anggota_id') == $a->anggota_id)
                                        <option value="{{ $a->anggota_id }}" selected>{{ $a->user->name }}
                                        </option>
                                    @else
                                        <option value="{{ $a->anggota_id }}">{{ $a->user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="@error('satker_id') text-danger  @enderror" for="satker_id">Satuan Kerja
                                    </label>
                                    @error('satker_id')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror


                                    <div class="input-group">
                                        <select class="form-control  select2bs4" multiple="multiple"
                                            data-placeholder="Pilih Anggota Tim " name="satker_id[]">
                                            <option value="">Pilih Satuan Kerja </option>
                                            @foreach ($satker as $value)
                                                @if (old('satker_id') == $value->id)
                                                    <option value="{{ $value->id }}" selected>
                                                        {{ $value->nama_satker }}
                                                    </option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->nama_satker }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat Pengawasan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Hapus --}}
    @foreach ($pengawasan as $value)
        <div class="modal fade" id="hapus{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus pengawasan dengan Nama:</p>
                        <b>{{ $value->anggota->name }}</b> pada Satuan Kerja
                        <b>{{ $value->satker->nama_satker }}</b>
                        ?
                    </div>
                    <form action="/pengawasan/{{ $value->id }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection
