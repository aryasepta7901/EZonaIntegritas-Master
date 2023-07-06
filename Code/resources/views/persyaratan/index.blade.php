@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
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
        @if (session()->has('failures'))
            <table class="table table-warning">
                <tr>
                    <th>Baris</th>
                    <th>Attribute</th>
                    <th>Error</th>
                    <th>Value</th>
                </tr>
                @foreach (session()->get('failures') as $validasi)
                    <tr>
                        <td>{{ $validasi->row() - 1 }}</td>
                        <td>{{ $validasi->attribute() }}</td>
                        <td>
                            <ul>
                                @foreach ($validasi->errors() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $validasi->values()[$validasi->attribute()] }}</td>
                    </tr>
                @endforeach

            </table>
        @endif

        <div class="card">
            <!-- /.card-header -->

            <div class="card-header d-flex justify-content-end">
                <button class="btn btn-primary " data-toggle="modal" data-target="#import"><i class="fa fa-file-import">
                    </i> Import Data</button>
                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                    </i> Tambah</button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive-lg">
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
                                <td class="text-center">
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
                            <label class="@error('satker_id') text-danger  @enderror " for="satker_id">Satker</label>
                            @error('satker_id')
                                <small class="badge badge-danger"> *{{ $message }}
                                </small>
                            @enderror
                            <select class="form-control select2bs4" multiple="multiple"
                                data-placeholder="Pilih Satuan Kerja " name="satker_id[]">
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
                            <label class="@error('persyaratan') text-danger  @enderror "
                                for="persyaratan">Persyaratan</label>
                            @error('persyaratan')
                                <small class="badge badge-danger"> *{{ $message }}
                                </small>
                            @enderror
                            <select class="form-control" name="persyaratan">
                                <option value="">Pilih Salah Satu</option>
                                <option value="wbk" @if (old('persyaratan') == 'wbk') selected @endif>Wilayah Bebas dari
                                    Korupsi
                                    (WBK)</option>
                                <option value="wbbm" @if (old('persyaratan') == 'wbbm') selected @endif>Wilayah Birokrasi
                                    Bersih dan Melayani (WBBM)</option>
                            </select>
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
        <div class="modal fade" id="edit{{ $value->id }}">
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

                                <select class="form-control" name="persyaratan">
                                    <option value="wbk" @if ($value->wbk == 1 && $value->wbbm == 0) ? selected @endif>Wilayah
                                        Bebas
                                        dari Korupsi (WBK)</option>
                                    <option value="wbbm" @if ($value->wbk == 1 && $value->wbbm == 1) ? selected @endif>Wilayah
                                        Birokrasi
                                        Bersih dan Melayani
                                        (WBBM)
                                    </option>
                                </select>
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
    {{-- Import --}}
    <div class="modal fade" id="import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Data Persyaratan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/persyaratan/import" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="excel"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <label class="custom-file-label" for="customFile">File Excel</label>
                        </div>

                        <p class="text-info"> Note: Silahkan Download Template Excel
                            File Yang diupload</p>
                        <p class="text-danger">format .xlsx / .csv</p>
                        <div class="d-flex justify-content-center">
                            <a type="button" href="{{ asset('excel/persyaratan.xlsx') }}"
                                class="btn btn-sm btn-info my-2"><i class="fas fa-file"></i> Download
                                Template</a>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
