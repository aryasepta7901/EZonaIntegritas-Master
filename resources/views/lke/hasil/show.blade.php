@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">

        <div class="card">
            <!-- /.card-header -->

            <div class="card-header d-flex justify-content-between">
                <p>{{ $pilar->pilar }}</p>
                <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                        Tambah</i></button>

            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Satuan kerja</th>
                            <th>Nilai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker_id }}</td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->nilai }}</button></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->id }}"><i class="fa fa-pen"></i></button>
                                    <a type="button" href="/rincian/{{ $value->id }}" class="btn btn-sm btn-info"><i
                                            class="fa fa-info"></i></a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#hapus{{ $value->id }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>


            </div>

        </div>
    </div>
@endsection
