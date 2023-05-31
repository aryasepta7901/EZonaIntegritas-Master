@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">

        <div class="card">
            <!-- /.card-header -->
            <div class="card-header d-flex justify-content-end">
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($pilar as $value)
                        <div class="col-lg-4 ">
                            <!-- small box -->
                            <div class="small-box bg-info ">
                                <div class="inner" style="height: 100px">

                                    <p class="text-center text-bold ">{{ $value->pilar }}</p>
                                </div>

                                <a href="/hasil/{{ $value->id }}" class="small-box-footer">Upload Dokumen <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endforeach



                </div>
            </div>

        </div>
    </div>
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
            <div class="card-header d-flex justify-content-between">
                <button class="btn btn-primary " data-toggle="modal" data-target="#import"><i class="fa fa-file-import">
                    </i> Import Data</button>
                <button class="btn btn-primary ml-auto" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                    </i> Tambah</button>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Satuan kerja</th>
                            @foreach ($pilar as $value)
                                <th class="text-sm">{{ $value->pilar }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($hasilSatker as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                @php
                                    $data = $hasil->where('satker_id', $value->satker_id);
                                @endphp
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data as $item)
                                    <td class="text-center"><button class="badge badge-info">{{ $item->nilai }}</button>
                                    </td>
                                    @php
                                        $total += $item->nilai; //total nilai
                                    @endphp
                                @endforeach
                                <td class="text-center"><button class="badge badge-info">{{ $total }}</button>
                                </td>
                                <td><button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->satker_id }}"><i class="fa fa-pen"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $value->satker_id }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>


                </table>
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
                                    <label for="satker_id">Satuan Kerja</label>
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
                            @foreach ($pilar as $value)
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="pilar">{{ $value->pilar }}</label>
                                        <input type="hidden" name="pilar_id{{ $value->id }}"
                                            value="{{ $value->id }}">
                                        <input type="hidden" name="bobot{{ $value->id }}" value="{{ $value->bobot }}">
                                        @foreach ($value->opsi as $item)
                                            <div class="form-check ml-4">
                                                <input class="form-check-input" type="radio" name="{{ $value->id }}"
                                                    value="{{ $item->id }}" required>
                                                <label class="form-check-label">{{ $item->rincian }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit --}}
    @foreach ($hasilSatker as $satker)
        <div class="modal fade" id="edit{{ $satker->satker_id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" action="/hasil/{{ $satker->satker_id }}">
                        @method('put')
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="satker_id">Satuan Kerja</label>

                                        <select class="form-control  select2bs4" name="satker_id" disabled>
                                            <option value="{{ $satker->satker_id }}">{{ $satker->satker->nama_satker }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                @foreach ($pilar as $value)
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="pilar">{{ $value->pilar }}</label>
                                            <input type="text" name="pilar_id{{ $value->id }}"
                                                value="{{ $value->id }}">
                                            <input type="hidden" name="bobot{{ $value->id }}"
                                                value="{{ $value->bobot }}">
                                            @foreach ($value->opsi as $item)
                                                <div class="form-check ml-4">
                                                    {{-- untuk mengambil data rekapHasil --}}
                                                    @php
                                                        $id = date('Y') . $satker->satker_id . $value['id'];
                                                        $RekapHasil = $hasil->where('id', $id)->first();
                                                    @endphp
                                                    <input @if ($RekapHasil->opsi_id == $item->id) checked @endif
                                                        class="form-check-input" type="radio"
                                                        name="{{ $value->id }}" value="{{ $item->id }}" required>
                                                    <label class="form-check-label">{{ $item->rincian }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach




    {{-- Hapus --}}
    @foreach ($hasilSatker as $value)
        <div class="modal fade" id="hapus{{ $value->satker_id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Nilai Hasil dari Satker:</p>
                        <b>{{ $value->satker->nama_satker }}
                            ?</b>
                    </div>
                    <form action="/hasil/{{ $value->satker_id }}" method="POST" class="d-inline">
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
                    <h4 class="modal-title">Import Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="/hasil/import" enctype="multipart/form-data">
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
