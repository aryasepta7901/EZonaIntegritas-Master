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

        <div class="card">
            <!-- /.card-header -->
            <div class="card-header d-flex justify-content-end">
                <div class="d-flex justify-content-between">

                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus">
                        </i> Tambah</button>

                </div>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($satker as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                @php
                                    $data = $hasil->where('satker_id', $value->satker_id);
                                @endphp
                                @foreach ($data as $item)
                                    <td class="text-center"><button class="badge badge-info">{{ $item->nilai }}</button>
                                    </td>
                                @endforeach
                                <td><button class="btn btn-sm btn-success" data-toggle="modal"
                                        data-target="#edit{{ $value->id }}"><i class="fa fa-pen"></i></button>
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
