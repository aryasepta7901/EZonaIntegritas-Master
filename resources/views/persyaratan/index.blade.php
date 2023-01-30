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
            <!-- /.card-header -->

            <div class="card-header d-flex justify-content-end">

                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                        Tambah</i></button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Satker </th>
                            <th>WBK</th>
                            <th>WBBM</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($persyaratan as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                <td class="text-center">
                                    @if ($value->wbk == 1)
                                        <button class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button class="badge badge-danger">X</button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($value->wbbm == 1)
                                        <button class="badge badge-success"><i class="fa fa-check"></i></button>
                                    @else
                                        <button class="badge badge-danger">X</button>
                                    @endif
                                </td>
                                <td class="text-danger">
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->id }}"><i class="fa fa-pen"></i></button>

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
                    <h4 class="modal-title">Tambah Persyaratan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/persyaratan">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="satker">Satker</label>
                            <select class="form-control select2bs4" name="satker_id">
                                <option value=''>Pilih Salah Satu </option>
                                @foreach ($satker as $s)
                                    @if (old('satker_id') == $s->id)
                                        <option value="{{ $s->id }}" selected>{{ $s->nama_satker }}
                                        </option>
                                    @else
                                        <option value="{{ $s->id }}">{{ $s->nama_satker }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="persyaratan">Persyaratan</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="wbk" value="1"
                                            name="wbk">
                                        <label for="wbk" class="custom-control-label">WBK</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="wbbm" value="1"
                                            name="wbbm">
                                        <label for="wbbm" class="custom-control-label">WBBM</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- edit --}}
    @foreach ($persyaratan as $value)
        <div class="modal fade" id="edit{{ $value['id'] }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Persyaratan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/persyaratan/{{ $value->id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="satker">Satker</label>
                                <select class="form-control select2bs4" name="satker_id" disabled>
                                    <option value='{{ $value->satker_id }}'>{{ $value->satker->nama_satker }} </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="persyaratan">Persyaratan</label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"
                                                @if ($value->wbk == 1) ? checked @endif
                                                id="wbk{{ $value->id }}" value="1" name="wbk">
                                            <label for="wbk{{ $value->id }}" class="custom-control-label">WBK</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox"
                                                @if ($value->wbbm == 1) ? checked @endif
                                                id="wbbm{{ $value->id }}" value="1" name="wbbm">
                                            <label for="wbbm{{ $value->id }}"
                                                class="custom-control-label">WBBM</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    {{-- Hapus --}}
    @foreach ($persyaratan as $value)
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
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Persyaratan Satuan kerja:</p>
                        <b>{{ $value->satker->nama_satker }}
                            ?</b>
                    </div>
                    <form action="/persyaratan/{{ $value->id }}" method="POST" class="d-inline">
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
