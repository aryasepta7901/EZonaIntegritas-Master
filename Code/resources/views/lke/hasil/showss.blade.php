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
        <div class="card">
            <!-- /.card-header -->

            <div class="card-header">
                <div class="d-flex justify-content-between">

                    <b>{{ $pilar->pilar }}</b>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                        </i>Tambah</button>

                </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Satuan kerja</th>
                            <th>Opsi</th>
                            <th>Nilai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                <td>{{ $value->opsi->rincian }}</td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->nilai }}</button>
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
            <div class="card-footer">
                <a href="/hasil" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
                    Kembali</a>
            </div>

        </div>
    </div>

    {{-- Tambah --}}
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/hasil">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="@error('satker_id') text-danger  @enderror " for="satker_id">Satuan
                                        Kerja</label>
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
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="@error('opsi_id') text-danger  @enderror " for="opsi_id">
                                        {{ $pilar->pilar }}</label>
                                    @error('opsi_id')
                                        <small class="badge badge-danger"> *{{ $message }}
                                        </small>
                                    @enderror
                                    <input type="hidden" name="pilar_id" value="{{ $pilar->id }}">
                                    <input type="hidden" name="bobot" value="{{ $pilar->bobot }}">
                                    @foreach ($pilar->opsi as $item)
                                        <div class="form-check ml-4">
                                            @if (old('opsi_id') == $item->id)
                                                <input class="form-check-input" type="radio" name="opsi_id"
                                                    value="{{ $item->id }}" checked>
                                                <label class="form-check-label">{{ $item->rincian }}</label>
                                            @else
                                                <input class="form-check-input" type="radio" name="opsi_id"
                                                    value="{{ $item->id }}">
                                                <label class="form-check-label">{{ $item->rincian }}</label>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Buat </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit --}}
    @foreach ($hasil as $value)
        <div class="modal fade" id="edit{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Data </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/hasil/{{ $value->id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="satker">Satker</label>
                                        <select class="form-control" name="satker_id">
                                            <option value="{{ $value->satker_id }}" selected>
                                                {{ $value->satker->nama_satker }}
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="pilar">{{ $pilar->pilar }}</label>
                                        <input type="hidden" name="pilar_id" value="{{ $pilar->id }}">
                                        <input type="hidden" name="bobot" value="{{ $pilar->bobot }}">
                                        @foreach ($pilar->opsi as $item)
                                            <div class="form-check ml-4">
                                                <input @if ($value->opsi_id == $item->id) checked @endif
                                                    class="form-check-input" type="radio" name="opsi_id"
                                                    value="{{ $item->id }}">
                                                <label class="form-check-label">{{ $item->rincian }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Ubah </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach


    {{-- Hapus --}}
    @foreach ($hasil as $value)
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
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Nilai Satker:</p>
                        <b>{{ $value->satker->nama_satker }} (Nilai: {{ $value->nilai }})
                            ?</b>
                    </div>
                    <form action="/hasil/{{ $value->id }}" method="POST" class="d-inline">
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
