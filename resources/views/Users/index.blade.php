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
            <div class="card-header d-flex justify-content-between">

                <button class="btn btn-primary " data-toggle="modal" data-target="#import"><i class="fa fa-file-import">
                    </i> Import Data</button>
                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                    </i> Tambah
                    User</button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Telpon</th>
                            <th>Level</th>
                            <th>Satker</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->id }}
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_telp }}</td>
                                <td>{{ $user->level->name }}</td>
                                <td>{{ $user->satker->nama_satker }}</td>

                                <td>
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $user->id }}"><i class="fa fa-pen"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $user->id }}"><i class="fa fa-trash"></i></button>
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
                    <h4 class="modal-title">Tambah Users</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/users">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Pengguna</label>
                            <input type="text" class="form-control @error('name') is-invalid  @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid  @enderror"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nip">Nomor Induk Pegawai</label>
                                    <input type="number" class="form-control  @error('id') is-invalid  @enderror"
                                        id="nip" name="id" value="{{ old('id') }}">
                                    @error('id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telpon">No Telpon</label>
                            <input type="number" class="form-control  @error('no_telp') is-invalid  @enderror"
                                id="telpon" name="no_telp" value="{{ old('no_telp') }}">
                            @error('no_telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror


                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="@error('level_id') text-danger  @enderror" for="level">Level</label>
                                    @error('level_id')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <select class="form-control select2bs4" name="level_id">
                                        <option value="">Pilih Salah Satu </option>
                                        @foreach ($level as $l)
                                            @if (old('level_id') == $l->id)
                                                <option value="{{ $l->id }}" selected>{{ $l->name }}
                                                </option>
                                            @else
                                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="@error('satker_id') text-danger  @enderror" for="satker">Satker</label>
                                    @error('satker_id')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <select class="form-control select2bs4" name="satker_id">
                                        <option value="">Pilih Salah Satu </option>
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
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Users</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit --}}
    @foreach ($users as $user)
        <div class="modal fade" id="edit{{ $user->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Users </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="users/{{ $user->id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Nama Pengguna</label>
                                <input type="text" class="form-control" id="name" name="name" readonly
                                    value="{{ $user->name }}">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            readonly value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nip">Nomor Induk Pegawai</label>
                                        <input type="number" class="form-control " id="nip" name="id"
                                            readonly value="{{ $user->id }}">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="telpon">No Telpon</label>
                                <input type="number" class="form-control  @error('no_telp') is-invalid  @enderror"
                                    id="telpon" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}">
                                @error('no_telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="@error('level_id') text-danger  @enderror"
                                            for="level">Level</label>
                                        @error('level_id')
                                            <small class="badge badge-danger"> *{{ $message }}
                                            </small>
                                        @enderror
                                        <select class="form-control select2bs4" name="level_id">
                                            @foreach ($level as $l)
                                                @if (old('level_id', $user->level_id) == $l->id)
                                                    <option value="{{ $l->id }}" selected>{{ $l->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <label class="@error('satker_id') text-danger  @enderror"
                                            for="satker">Satker</label>
                                        @error('satker_id')
                                            <small class="badge badge-danger"> *{{ $message }}
                                            </small>
                                        @enderror
                                        <select class="form-control select2bs4" name="satker_id">
                                            @foreach ($satker as $s)
                                                @if (old('satker_id', $user->satker_id) == $s->id)
                                                    <option value="{{ $s->id }}" selected>
                                                        {{ $s->nama_satker }}
                                                    </option>
                                                @else
                                                    <option value="{{ $s->id }}">{{ $s->nama_satker }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Users</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach



    {{-- Hapus --}}
    @foreach ($users as $user)
        <div class="modal fade" id="hapus{{ $user->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus User dengan Nama:</p>
                        <b>{{ $user->name }}
                            ?</b>
                    </div>
                    <form action="/users/{{ $user->id }}" method="POST" class="d-inline">
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
                    <h4 class="modal-title">Import Data User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/users/import" enctype="multipart/form-data">
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
                            <a type="button" href="{{ asset('excel/users.xlsx') }}" class="btn btn-sm btn-info my-2"><i
                                    class="fas fa-file"></i> Download
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
