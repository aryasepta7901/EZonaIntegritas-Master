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

                                        {{-- <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#tambah{{ $sr->id }}"><i class="fas fa-plus"></i></button> --}}
                                        <button class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#edit{{ $sr->id }}"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#hapus{{ $sr->id }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @foreach ($sr->pilar as $p)
                                    <tr style="background-color: rgb(0, 255, 119)" id="accordion{{ $sr->rincian_id }}">
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
                                    </tr>
                                    @foreach ($p->subPilar as $sp)
                                        <tr style="background-color: rgb(255, 166, 0)" id="accordion{{ $sr->rincian_id }}">
                                            <td data-toggle="collapse" data-target="#accordion{{ $sp->id }}"
                                                class="collapse" id="accordion{{ $sp->pilar_id }}">
                                                {{ $loop->iteration }} <i class="fa-solid fa-caret-down"></i></td>
                                            <td data-toggle="collapse" data-target="#accordion{{ $sp->id }}"
                                                class="collapse" id="accordion{{ $sp->pilar_id }}">{{ $sp->subPilar }}
                                            </td>
                                            <td data-toggle="collapse" data-target="#accordion{{ $sp->id }}"
                                                class="collapse" id="accordion{{ $sp->pilar_id }}">{{ $sp->bobot }}
                                            </td>
                                        </tr>
                                        @foreach ($sp->pertanyaan as $p)
                                            <tr id="accordion{{ $sr->rincian_id }}">
                                                <td class="collapse" id="accordion{{ $p->subpilar_id }}">
                                                    {{ $loop->iteration }}</td>
                                                <td class="collapse" id="accordion{{ $p->subpilar_id }}">
                                                    {{ $p->pertanyaan }}</td>
                                                <td class="collapse" id="accordion{{ $p->subpilar_id }}">
                                                    {{ $p->bobot }}
                                                </td>
                                            </tr>
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
                        <button type="submit" class="btn btn-primary">Create Rincian</button>
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


    @foreach ($rincian as $r)
        @foreach ($r->subRincian as $value)
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
                                <button type="submit" class="btn btn-primary">Create Sub Rincian</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            {{-- Edit --}}

            <div class="modal fade" id="edit{{ $value->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Sub Rincian</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form method="post" action="/subrincian/{{ $value->id }}">
                            @method('put')
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="rincian" value="{{ $r->id }}">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="subRincian">Sub Rincian</label>
                                            <input type="text"
                                                class="form-control @error('subRincian') is-invalid  @enderror"
                                                id="subRincian" name="subRincian"
                                                value="{{ old('subRincian', $value->subRincian) }}"
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
                            <p class="text-danger">Apakah Anda Yakin untuk Menghapus SubRincian dengan Nama:</p>
                            <b>{{ $value->subRincian }}
                                ?</b>
                        </div>
                        <form action="/subrincian/{{ $value->id }}" method="POST" class="d-inline">
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
    @endforeach


@endsection
