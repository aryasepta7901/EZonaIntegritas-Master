@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
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
                <a href="/pertanyaan/create" class="btn btn-primary mb-3"><i class="fa fa-plus"> Tambah
                        Pertanyaan</i></a>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pertanyaan as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->pertanyaan }}</td>
                                <td>
                                    <ul>
                                        @foreach ($value->opsi as $item)
                                            <li>{{ $item->rincian }} <button
                                                    class="badge badge-info">{{ $item->bobot }}</button></li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="text-center"> <button class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#info{{ $value->id }}"><i class="fa fa-info"></i></button></td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->bobot }}</button></td>
                                </td>


                                <td class="text-center">
                                    <a href="/pertanyaan/{{ $value->id }}/edit" class="btn btn-sm btn-success"><i
                                            class="fa fa-pen">
                                        </i></a>
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
                        {!! $value->info !!}
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


    @foreach ($pertanyaan as $value)
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
                        <p class="text-danger">Apakah Anda Yakin untuk Menghapus Pertanyaan dengan Isi:</p>
                        <b>{{ $value->pertanyaan }}
                            ?</b>
                    </div>
                    <form action="/pertanyaan/{{ $value->id }}" method="POST" class="d-inline">
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
