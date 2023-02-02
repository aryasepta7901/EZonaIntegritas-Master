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
                            <th>Pertanyaan</th>
                            <th>Penjelasan</th>
                            <th>Info</th>
                            <th>Bobot</th>
                            <th>Opsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pertanyaan as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->pertanyaan }}</td>
                                <td>{{ $value->penjelasan }}</td>
                                <td class="text-center"> <button class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#info{{ $value->id }}"><i class="fa fa-info"></i></button></td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->bobot }}</button></td>
                                </td>
                                <td>{{ $value->opsi }}</td>

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
            <div class="card-footer">
                @php
                    $kembali = substr($subPilar->id, 0, 3);
                @endphp
                <a href="/pilar/{{ $kembali }}" class="btn btn-secondary"><i class="fa fa-backward"></i>
                    Kembali</a>
            </div>
        </div>
    </div>


    {{-- Info --}}
    @foreach ($pertanyaan as $value)
        <div class="modal fade" id="info{{ $value->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Informasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Bukti Dukung:</p>
                        <ul>
                            @foreach ($value->dokumen as $item)
                                <li>{{ $item->dokumen }}</li>
                            @endforeach
                        </ul>
                        <p>{{ $value->info }}</p>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach






@endsection
