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
            <div class="card-header d-flex justify-content-between">


                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                    </i> Tambah
                    User</button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-responsive-lg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($status as $value)
                            @if ($value->start_time != null)
                                <tr>
                                    <td>{{ $value->status }}</td>
                                    <td>{{ $value->start_time }}</td>
                                    <td>{{ $value->end_time }}</td>
                                    {{-- @php
                                        $diff = date_diff(now(), $value->end_time);
                                    @endphp --}}
                                    @php
                                        
                                        $awal = date_create(now());
                                        $akhir = date_create($value->end_time); // waktu sekarang
                                        $diff = date_diff($awal, $akhir);
                                        $waktuAwal = strtotime(now());
                                        $waktuAkhir = strtotime($value->end_time);
                                        
                                        // echo 'Selisih waktu: ';
                                        // echo $diff->m . ' bulan, ';
                                        // echo $diff->d . ' hari, ';
                                        // echo $diff->h . ' jam, ';
                                        // echo $diff->i . ' menit, ';
                                        // echo $diff->s . ' detik, ';
                                        
                                    @endphp

                                    @if ($waktuAwal < $waktuAkhir)
                                        @if ($diff->d == 0 && $diff->h != 0)
                                            <td><button class="badge badge-info">{{ $diff->h }} Jam Lagi
                                                </button></td>
                                        @elseif($diff->d == 0)
                                            <td><button class="badge badge-info">{{ $diff->i }} Menit Lagi
                                                </button></td>
                                        @else
                                            <td><button class="badge badge-info">{{ $diff->d }} Hari Lagi </button>
                                            </td>
                                        @endif
                                    @else
                                        <td><button class="badge badge-danger">Waktu Berakhir</button></td>
                                    @endif

                                    {{-- <td>{{ $diff }}</td> --}}
                                    {{-- <td>
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $user->id }}"><i class="fa fa-pen"></i></button>

                                </td> --}}
                                </tr>
                            @endif
                        @endforeach


                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    {{-- Tambah --}}
    {{-- <div class="modal fade" id="tambah">
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
                        <button type="submit" class="btn btn-primary">Buat Users</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}





    {{-- Hapus --}}
    {{-- @foreach ($users as $user)
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
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach --}}



@endsection
