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

            <div class="card-header d-flex justify-content-end">

                <button class="btn btn-primary" data-toggle="modal" data-target="#tambahRincian"><i class="fa fa-plus">
                    </i> Tambah</button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered  table-hover">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 30px">No</th>
                            <th style="width: 500px">Rincian</th>
                            <th>Bobot</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rincian as $value)
                            <tr style="background-color: rgb(246, 255, 0)">
                                <th data-toggle="collapse" data-target="#accordion{{ $value->id }}">
                                    {{ chr(64 + $loop->iteration) }} <i class="fa-solid fa-caret-down"></i></th>
                                <th data-toggle="collapse" data-target="#accordion{{ $value->id }}">{{ $value->rincian }}
                                </th>
                                <th data-toggle="collapse" data-target="#accordion{{ $value->id }}">{{ $value->bobot }}
                                </th>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#tambah{{ $value->id }}"><i class="fas fa-plus"></i></button>
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->id }}"><i class="fas fa-pen"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $value->id }}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>

                            @foreach ($value->subRincian as $sr)
                                <tr style="background-color: rgb(255, 0, 30)">
                                    <th data-toggle="collapse" data-target="#accordion{{ $sr->id }}" class="collapse"
                                        id="accordion{{ $sr->rincian_id }}">{{ $loop->iteration }} <i
                                            class="fa-solid fa-caret-down"></i></th>
                                    <th data-toggle="collapse" data-target="#accordion{{ $sr->id }}" class="collapse"
                                        id="accordion{{ $sr->rincian_id }}">{{ $sr->subRincian }}</th>
                                    <th data-toggle="collapse" data-target="#accordion{{ $sr->id }}" class="collapse"
                                        id="accordion{{ $sr->rincian_id }}">{{ $sr->bobot }}</th>
                                    <td class="collapse text-center" id="accordion{{ $sr->rincian_id }}">

                                        <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#tambah{{ $sr->id }}"><i class="fas fa-plus"></i></button>
                                        <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#edit{{ $sr->id }}"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapus{{ $sr->id }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @foreach ($sr->pilar as $p)
                                    <tr style="background-color: rgb(0, 255, 119)">
                                        <td data-toggle="collapse" data-target="#accordion{{ $p->id }}"
                                            class="collapse" id="accordion{{ $p->subrincian_id }}">{{ $loop->iteration }}
                                            <i class="fa-solid fa-caret-down"></i>
                                        </td>
                                        <td data-toggle="collapse" data-target="#accordion{{ $p->id }}"
                                            class="collapse" id="accordion{{ $p->subrincian_id }}">{{ $p->pilar }}
                                        </td>
                                        <td data-toggle="collapse" data-target="#accordion{{ $p->id }}"
                                            class="collapse" id="accordion{{ $p->subrincian_id }}">{{ $p->bobot }}
                                        </td>
                                        <td class="collapse text-center" id="accordion{{ $p->subrincian_id }}">

                                            <button class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#tambah{{ $p->id }}"><i
                                                    class="fas fa-plus"></i></button>
                                            <button class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#edit{{ $p->id }}"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#hapus{{ $p->id }}"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @foreach ($p->subPilar as $sp)
                                        <tr style="background-color: rgb(255, 166, 0)">
                                            <td data-toggle="collapse" data-target="#accordion{{ $sp->id }}"
                                                class="collapse" id="accordion{{ $sp->pilar_id }}">
                                                {{ $loop->iteration }} <i class="fa-solid fa-caret-down"></i></td>
                                            <td data-toggle="collapse" data-target="#accordion{{ $sp->id }}"
                                                class="collapse" id="accordion{{ $sp->pilar_id }}">{{ $sp->subPilar }}
                                            </td>
                                            <td data-toggle="collapse" data-target="#accordion{{ $sp->id }}"
                                                class="collapse" id="accordion{{ $sp->pilar_id }}">{{ $sp->bobot }}
                                            </td>
                                            <td class="collapse text-center" id="accordion{{ $sp->pilar_id }}">

                                                <a href="/pertanyaan/{{ $sp->id }}"
                                                    class="btn btn-sm btn-primary "><i class="fa fa-plus"> </i> </a>
                                                <button class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#edit{{ $sp->id }}"><i
                                                        class="fas fa-pen"></i></button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#hapus{{ $sp->id }}"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @foreach ($sp->pertanyaan as $p)
                                            <tr style="background-color: rgb(178, 173, 163)">
                                                <td class="collapse" id="accordion{{ $p->subpilar_id }}">
                                                    {{ $loop->iteration }}</td>
                                                <td class="collapse" id="accordion{{ $p->subpilar_id }}">
                                                    {{ $p->pertanyaan }}</td>
                                                <td class="collapse" id="accordion{{ $p->subpilar_id }}">
                                                    {{ $p->bobot }}
                                                </td>

                                                <td class="collapse text-center" id="accordion{{ $p->subpilar_id }}">
                                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                                        data-target="#info{{ $p->id }}"><i
                                                            class="fas fa-eye"></i></button>
                                                    <a href="/pertanyaan/{{ $p->id }}/edit"
                                                        class="btn btn-sm btn-success"><i class="fa fa-pen">
                                                        </i></a>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#hapus{{ $p->id }}"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>

                                            </tr>
                                            {{-- Codingan Pemanis saja --}}
                                            @foreach ($p->opsi as $o)
                                                <tr>
                                                    <td class="collapse" id="accordion{{ $o->pertanyaan_id }}">

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach

                    </tbody>


                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    {{-- rincian --}}
    {{-- Tambah --}}
    <div class="modal fade" id="tambahRincian">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Rincian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/rincian">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="rincian">Rincian</label>
                                    <input type="text" class="form-control @error('rincian') is-invalid  @enderror"
                                        id="rincian" name="rincian" value="{{ old('rincian') }}"
                                        placeholder="Isi Nama Rincian">
                                    @error('rincian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Rincian</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Edit --}}
    @foreach ($rincian as $value)
        <div class="modal fade" id="edit{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Rincian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/rincian/{{ $value->id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="rincian">Rincian</label>
                                        <input type="text" class="form-control @error('rincian') is-invalid  @enderror"
                                            id="rincian" name="rincian" value="{{ old('rincian', $value->rincian) }}"
                                            placeholder="Isi Nama Rincian">
                                        @error('rincian')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit_rincian" class="btn btn-primary">Edit Rincian</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
    {{-- Hapus --}}
    @foreach ($rincian as $value)
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
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Rincian dengan Nama:</p>
                        <b>{{ $value->rincian }}
                            ?</b>
                    </div>
                    <form action="/rincian/{{ $value->id }}" method="POST" class="d-inline">
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



    {{-- subRincian ,Pilar, SubPilar,Pertanyaan --}}
    @foreach ($rincian as $r)
        {{-- Subrincian --}}
        {{-- Tambah --}}
        <div class="modal fade" id="tambah{{ $r->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Sub Rincian</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/subrincian">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="rincian" value="{{ $r->id }}">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="Rincian">Rincian</label>

                                        <input class="form-control" readonly type="text" name="rincian_name"
                                            value="{{ $r->rincian }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="subRincian">Sub Rincian</label>
                                        <input type="text"
                                            class="form-control @error('subRincian') is-invalid  @enderror"
                                            id="subRincian" name="subRincian" value="{{ old('subRincian') }}"
                                            placeholder="Isi Nama Sub Rincian">
                                        @error('subRincian')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah Sub Rincian</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        @foreach ($r->subRincian as $sr)
            {{-- Edit --}}
            <div class="modal fade" id="edit{{ $sr->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Sub Rincian</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form method="post" action="/subrincian/{{ $sr->id }}">
                            @method('put')
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="rincian" value="{{ $r->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="Rincian">Rincian</label>
                                            <input class="form-control" readonly type="text" name="rincian_name"
                                                value="{{ $r->rincian }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="subRincian">Sub Rincian</label>
                                            <input type="text"
                                                class="form-control @error('subRincian') is-invalid  @enderror"
                                                id="subRincian" name="subRincian"
                                                value="{{ old('subRincian', $sr->subRincian) }}"
                                                placeholder="Isi Nama Sub Rincian">
                                            @error('subRincian')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Edit SubRincian</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            {{-- Hapus --}}
            <div class="modal fade" id="hapus{{ $sr->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Hapus</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger">Apakah Anda Yakin untuk Menghapus SubRincian dengan Nama:</p>
                            <b>{{ $sr->subRincian }}
                                ?</b>
                        </div>
                        <form action="/subrincian/{{ $sr->id }}" method="POST" class="d-inline">
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
            {{-- Pilar --}}
            {{-- Tambah --}}
            <div class="modal fade" id="tambah{{ $sr->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Pilar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form method="post" action="/pilar">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="subrincian_id" value="{{ $sr->id }}">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Rincian">Rincian</label>
                                            <input class="form-control" readonly type="text" name="rincian_name"
                                                value="{{ $r->rincian }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="SubRincian">Sub Rincian</label>
                                            <input class="form-control" readonly type="text" name="subrincian_name"
                                                value="{{ $sr->subRincian }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="pilar">Pilar</label>
                                            <input type="text"
                                                class="form-control @error('pilar') is-invalid  @enderror" id="pilar"
                                                name="pilar" value="{{ old('pilar') }}" placeholder="Isi Nama Pilar">
                                            @error('pilar')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="min_wbk">Minimal WBK</label>
                                            <input type="number"
                                                class="form-control @error('min_wbk') is-invalid  @enderror"
                                                id="min_wbk" name="min_wbk" value="{{ old('min_wbk') }}"
                                                placeholder="Isi Nilai Minimal WBK" min="0" step=".01">
                                            @error('min_wbk')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="min_wbbm">Minimal WBBM</label>
                                            <input type="number"
                                                class="form-control @error('min_wbbm') is-invalid  @enderror"
                                                id="min_wbbm" name="min_wbbm" value="{{ old('min_wbbm') }}"
                                                placeholder="Isi Nilai min_wbbm" min="0" step=".01">
                                            @error('min_wbbm')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah Pilar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            @foreach ($sr->pilar as $p)
                {{-- Edit --}}
                <div class="modal fade" id="edit{{ $p->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Pilar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form method="post" action="/pilar/{{ $p->id }}">
                                @method('put')
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="subrincian_id" value="{{ $sr->id }}">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="Rincian">Rincian</label>
                                                <input class="form-control" readonly type="text" name="rincian_name"
                                                    value="{{ $r->rincian }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="SubRincian">Sub Rincian</label>
                                                <input class="form-control" readonly type="text"
                                                    name="subrincian_name" value="{{ $sr->subRincian }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="pilar">Pilar</label>
                                                <input type="text"
                                                    class="form-control @error('pilar') is-invalid  @enderror"
                                                    id="pilar" name="pilar" value="{{ old('pilar', $p->pilar) }}"
                                                    placeholder="Isi Nama Pilar">
                                                @error('pilar')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="min_wbk">Minimal WBK</label>
                                                <input type="number"
                                                    class="form-control @error('min_wbk') is-invalid  @enderror"
                                                    id="min_wbk" name="min_wbk"
                                                    value="{{ old('min_wbk', $p->min_wbk) }}"
                                                    placeholder="Isi Nilai Minimal WBK" min="0" step=".01">
                                                @error('min_wbk')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="min_wbbm">Minimal WBBM</label>
                                                <input type="number"
                                                    class="form-control @error('min_wbbm') is-invalid  @enderror"
                                                    id="min_wbbm" name="min_wbbm"
                                                    value="{{ old('min_wbbm', $p->min_wbbm) }}"
                                                    placeholder="Isi Nilai min_wbbm" min="0" step=".01">
                                                @error('min_wbbm')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Pilar</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Hapus --}}
                <div class="modal fade" id="hapus{{ $p->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Hapus</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="text-danger">Apakah Anda Yakin untuk Menghapus Pilar dengan Nama:</p>
                                <b>{{ $p->pilar }}
                                    ?</b>
                            </div>
                            <form action="/pilar/{{ $p->id }}" method="POST" class="d-inline">
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
                {{-- SubPilar --}}
                {{-- Tambah --}}
                <div class="modal fade" id="tambah{{ $p->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah SubPilar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form method="post" action="/subpilar">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="pilar_id" value="{{ $p->id }}">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="Rincian">Rincian</label>
                                                <input class="form-control" readonly type="text" name="rincian_name"
                                                    value="{{ $r->rincian }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="SubRincian">Sub Rincian</label>
                                                <input class="form-control" readonly type="text"
                                                    name="subrincian_name" value="{{ $sr->subRincian }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="Pilar">Pilar</label>
                                                <input class="form-control" readonly type="text" name="pilar_name"
                                                    value="{{ $p->pilar }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="subPilar">SubPilar</label>
                                                <input type="text"
                                                    class="form-control @error('subPilar') is-invalid  @enderror"
                                                    id="subPilar" name="subPilar" value="{{ old('subPilar') }}"
                                                    placeholder="Isi Nama subPilar">
                                                @error('subPilar')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="bobot">Bobot</label>
                                                <input type="number"
                                                    class="form-control @error('bobot') is-invalid  @enderror"
                                                    id="bobot" name="bobot" value="{{ old('bobot') }}"
                                                    placeholder="Isi Nilai Bobot" min="0" step=".01">
                                                @error('bobot')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create SubPilar</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                @foreach ($p->subPilar as $sp)
                    {{-- Edit --}}
                    <div class="modal fade" id="edit{{ $sp->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit SubPilar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form method="post" action="/subpilar/{{ $sp['id'] }}">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="pilar_id" value="{{ $p->id }}">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="subPilar">SubPilar</label>
                                                    <input type="text"
                                                        class="form-control @error('subPilar') is-invalid  @enderror"
                                                        id="subPilar" name="subPilar"
                                                        value="{{ old('subPilar', $sp->subPilar) }}"
                                                        placeholder="Isi Nama subPilar">
                                                    @error('subPilar')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="bobot">Bobot</label>
                                                    <input type="number"
                                                        class="form-control @error('bobot') is-invalid  @enderror"
                                                        id="bobot" name="bobot"
                                                        value="{{ old('bobot', $sp->bobot) }}"
                                                        placeholder="Isi Nilai Bobot" min="0" step=".01">
                                                    @error('bobot')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Edit SubPilar</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    {{-- Hapus --}}
                    <div class="modal fade" id="hapus{{ $sp->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Hapus</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-danger">Apakah Anda Yakin untuk Menghapus Sub Pilar dengan Nama:</p>
                                    <b>{{ $sp->subPilar }}
                                        ?</b>
                                </div>
                                <form action="/subpilar/{{ $sp->id }}" method="POST" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Delete</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    @foreach ($sp->pertanyaan as $p)
                        {{-- Informasi --}}
                        <div class="modal fade" id="info{{ $p->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Informasi</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <b>Opsi Jawaban:</b>
                                        <ul>
                                            @foreach ($p->opsi as $item)
                                                <li>{{ $item->rincian }} <button
                                                        class="badge badge-info">{{ $item->bobot }}</button></li>
                                            @endforeach
                                        </ul>
                                        <b>Bukti Dukung:</b>
                                        <ul>
                                            @foreach ($p->dokumen as $item)
                                                <li>{{ $item->dokumen }}</li>
                                            @endforeach
                                        </ul>
                                        {!! $p->info !!}
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        {{-- Hapus --}}
                        <div class="modal fade" id="hapus{{ $p->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Hapus</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Pertanyaan dengan Isi:</p>
                                        <b>{{ $p->pertanyaan }}
                                            ?</b>
                                    </div>
                                    <form action="/pertanyaan/{{ $p->id }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    @endforeach


@endsection
