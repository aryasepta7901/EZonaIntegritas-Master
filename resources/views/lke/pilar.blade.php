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
                            <th>Pilar</th>
                            {{-- Buat halaman rincian hasil --}}
                            @if ($subrincian->id == 'HB' || $subrincian->id == 'HP')
                                <th>Penjelasan</th>
                            @endif

                            <th>Bobot</th>
                            <th>Minimal WBK</th>
                            <th>Minimal WBBM</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pilar as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->pilar }}</td>

                                @if ($subrincian->id == 'HB' || $subrincian->id == 'HP')
                                    <td>
                                        <ul>
                                            @foreach ($value->opsi as $item)
                                                <li>{{ $item->rincian }} <button
                                                        class="badge badge-info">{{ $item->bobot }}</button></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                @endif
                                <td class="text-center"><button class="badge badge-info">{{ $value->bobot }}</button></td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->min_wbk }}</button></td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->min_wbbm }}</button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->id }}"><i class="fa fa-pen"></i></button>
                                    {{-- Agar Rincian Hasil Tidak Bergerak --}}
                                    @if ($value->subrincian_id != 'HB' && $value->subrincian_id != 'HP')
                                        <a type="button" href="/pilar/{{ $value->id }}" class="btn btn-sm btn-info"><i
                                                class="fa fa-info"></i></a>
                                    @endif
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $value->id }}"><i class="fa fa-trash"></i></button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                @php
                    $kembali = substr($subrincian->id, 0, 1);
                @endphp
                <a href="/rincian/{{ $kembali }}" class="btn btn-secondary"><i class="fa fa-backward"></i>
                    Kembali</a>
            </div>
        </div>
    </div>

    {{-- Tambah --}}
    <div class="modal fade" id="tambah">
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
                            <input type="hidden" name="subrincian_id" value="{{ $subrincian->id }}">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="pilar">Pilar</label>
                                    <input type="text" class="form-control @error('pilar') is-invalid  @enderror"
                                        id="pilar" name="pilar" value="{{ old('pilar') }}"
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
                                    <input type="number" class="form-control @error('min_wbk') is-invalid  @enderror"
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
                                    <input type="number" class="form-control @error('min_wbbm') is-invalid  @enderror"
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
                        <button type="submit" class="btn btn-primary">Create Pilar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Edit --}}
    @foreach ($pilar as $value)
        <div class="modal fade" id="edit{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Pilar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/pilar/{{ $value->id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="subrincian_id" value="{{ $subrincian->id }}">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="pilar">Pilar</label>
                                        <input type="text" class="form-control @error('pilar') is-invalid  @enderror"
                                            id="pilar" name="pilar" value="{{ old('pilar', $value->pilar) }}"
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
                                        <input type="number" class="form-control @error('min_wbk') is-invalid  @enderror"
                                            id="min_wbk" name="min_wbk" value="{{ old('min_wbk', $value->min_wbk) }}"
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
                                            class="form-control @error('min_wbbm') is-invalid  @enderror" id="min_wbbm"
                                            name="min_wbbm" value="{{ old('min_wbbm', $value->min_wbbm) }}"
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
    @endforeach


    {{-- Hapus --}}
    @foreach ($pilar as $value)
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
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Pilar dengan Nama:</p>
                        <b>{{ $value->pilar }}
                            ?</b>
                    </div>
                    <form action="/pilar/{{ $value->id }}" method="POST" class="d-inline">
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
