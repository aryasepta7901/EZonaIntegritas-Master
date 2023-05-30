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
            <table class="table  table-responsive table-warning">
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
                    </i> Tambah
                    TPI</button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tim </th>
                            <th>Wilayah</th>
                            <th>Dalnis</th>
                            <th>Ketua Tim</th>
                            <th>Anggota Tim</th>
                            <th>Jumlah Pengawasan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($tpi as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->wilayah }}</td>
                                <td>{{ $value->user->name }}</td>
                                <td>{{ $value->ketua->name }}</td>
                                <td>
                                    @foreach ($value->anggota as $a)
                                        {{ $a->user->name }}
                                        <hr>
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $jumlah_satker = $value->pengawasan->count();
                                    @endphp
                                    {{ $jumlah_satker }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->id }}"><i class="fa fa-pen"></i></button>
                                    <a type="button" href="/tim/{{ $value->id }}" class="btn btn-sm btn-info"><i
                                            class="fa fa-info"></i></a>
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
        <!-- /.card -->
    </div>


    {{-- Tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah TPI</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/tim">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nama">Nama Tim</label>
                                    <input type="text" class="form-control @error('nama') is-invalid  @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="@error('wilayah') text-danger  @enderror" for="wilayah">Wilayah</label>
                                    @error('wilayah')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <select class="form-control" name="wilayah">
                                        <option value="">Pilih Wilayah TPI </option>
                                        <option value="1" @if (old('wilayah') == 1) selected @endif>Wilayah 1
                                        </option>
                                        <option value="2" @if (old('wilayah') == 2) selected @endif>Wilayah 2
                                        </option>
                                        <option value="3" @if (old('wilayah') == 3) selected @endif>Wilayah 3
                                        </option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="@error('dalnis') text-danger  @enderror " for="dalnis">Dalnis</label>
                                    @error('dalnis')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <select class="form-control select2bs4" name="dalnis">
                                        <option value="">Pilih Dalnis</option>
                                        @foreach ($dalnis as $d)
                                            @if (old('dalnis') == $d->id)
                                                <option value="{{ $d->id }}" selected>{{ $d->name }}
                                                </option>
                                            @else
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="@error('ketua_tim') text-danger  @enderror" for="ketua_tim">Ketua
                                        Tim</label>
                                    @error('ketua_tim')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <select class="form-control select2bs4" name="ketua_tim">
                                        <option value="">Pilih Ketua Tim </option>
                                        @foreach ($ketua_tim as $value)
                                            @if (old('ketua_tim') == $value->id)
                                                <option value="{{ $value->id }}" selected>{{ $value->name }}
                                                </option>
                                            @else
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="@error('anggota') text-danger  @enderror" for="anggota">Anggota Tim
                                    </label>
                                    @error('anggota')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <div class="input-group">
                                        <select class="form-control select2bs4" multiple="multiple"
                                            data-placeholder="Pilih Anggota Tim " name="anggota[]">
                                            @foreach ($anggota as $value)
                                                @if (old('anggota') == $value->id)
                                                    <option value="{{ $value->id }}" selected>{{ $value->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                        <button type="submit" class="btn btn-primary">Buat TPI</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit --}}
    @foreach ($tpi as $value)
        <div class="modal fade" id="edit{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit TPI</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/tim/{{ $value->id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Tim</label>
                                        <input type="text" class="form-control @error('nama') is-invalid  @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $value->nama) }}">
                                        @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="@error('wilayah') text-danger  @enderror"
                                            for="wilayah">Wilayah</label>
                                        @error('satker_id')
                                            <small class="badge badge-danger"> *{{ $message }}
                                            </small>
                                        @enderror
                                        <select class="form-control" name="wilayah">
                                            <option value="1" @if ($value->wilayah == 1) ? selected @endif>
                                                Wilayah 1</option>
                                            <option value="2" @if ($value->wilayah == 2) ? selected @endif>
                                                Wilayah 2</option>
                                            <option value="3" @if ($value->wilayah == 3) ? selected @endif>
                                                Wilayah 3</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="@error('dalnis') text-danger  @enderror" for="dalnis">Pengendali
                                            Teknis</label>
                                        @error('dalnis')
                                            <small class="badge badge-danger"> *{{ $message }}
                                            </small>
                                        @enderror
                                        <select class="form-control select2bs4" name="dalnis">
                                            @foreach ($dalnis as $d)
                                                @if (old('dalnis', $value->dalnis) == $d->id)
                                                    <option value="{{ $d->id }}" selected>{{ $d->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="@error('ketua_tim') text-danger  @enderror" for="ketua_tim">Ketua
                                            Tim</label>
                                        @error('ketua_tim')
                                            <small class="badge badge-danger"> *{{ $message }}
                                            </small>
                                        @enderror
                                        <select class="form-control select2bs4" name="ketua_tim">
                                            <option value="{{ $value->ketua_tim }}">{{ $value->ketua->name }} </option>
                                            @foreach ($ketua_tim as $k)
                                                @if (old('ketua_tim', $value->ketua_tim) == $k->id)
                                                    <option value="{{ $k->id }}" selected>{{ $k->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">
                                    <label class="@error('anggota') text-danger  @enderror" for="anggota">Anggota Tim
                                    </label>
                                    @error('anggota')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select class="form-control select2bs4" multiple="multiple"
                                                data-placeholder="Pilih Anggota Tim " name="anggota[]">
                                                @foreach ($value->anggota as $a)
                                                    <option selected value="{{ $a->anggota_id }}">
                                                        {{ $a->user->name }}
                                                    </option>
                                                @endforeach
                                                @foreach ($anggota as $value)
                                                    @if (old('anggota') == $value->id)
                                                        <option value="{{ $value->id }}" selected>
                                                            {{ $value->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $value->id }}">{{ $value->name }}
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
                            <button type="submit" class="btn btn-primary">Ubah TPI</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    {{-- Hapus --}}
    @foreach ($tpi as $value)
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
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus TPI dengan Nama:</p>
                        <b>{{ $value->nama }}
                            ?</b>
                    </div>
                    <form action="/tim/{{ $value->id }}" method="POST" class="d-inline">
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

    {{-- Import --}}
    <div class="modal fade" id="import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Data TPI</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/tim/import" enctype="multipart/form-data">
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
                            <a type="button" href="{{ asset('excel/tpi.xlsx') }}" class="btn btn-sm btn-info my-2"><i
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
