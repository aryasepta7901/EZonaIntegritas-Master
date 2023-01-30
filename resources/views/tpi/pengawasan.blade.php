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
                                <li>{{ $a->user->name }}</li> : <button class="badge badge-info">{{ $a->jumlah_satker }}
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
            <!-- /.card-header -->
            <div class="card-header d-flex justify-content-end">

                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                        Tambah
                        Pengawasan</i></button>
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
                            <label for="anggota_id">Anggota</label>
                            <select class="form-control" name="anggota_id" required>
                                <option value="">Pilih Anggota</option>
                                @foreach ($anggota as $a)
                                    @if (old('anggota_id') == $a->id)
                                        <option value="{{ $a->anggota }}" selected>{{ $a->user->name }}
                                        </option>
                                    @else
                                        <option value="{{ $a->anggota }}">{{ $a->user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            {{-- <input id="nilai" class='InputText' value='0' name="nilai"> <button type="button"
                                class='PLUS'>+</button>

                            @php
                                $count = 1;
                            @endphp --}}
                            {{-- @for ($i = 0; $i < $count; $i++) --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="satker_id">Satuan Kerja</label>
                                    <button id="rowSatker" type="button" class="btn btn-dark">
                                        <span class="fa fa-plus">
                                        </span>
                                    </button>
                                    <hr>
                                    <div class="input-group">
                                        <select id="prefselect1" class="form-control preferenceSelect select2bs4"
                                            name="satker_id[]" required>
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
                            <div id="inputSatker" class="col-lg-12"></div>
                            {{-- @endfor --}}



                        </div>



                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Pengawasan</button>
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
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection
