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
                                <td class="text-center"><button class="badge badge-info">{{ $value->bobot }}</button></td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->min_wbk }}</button></td>
                                <td class="text-center"><button class="badge badge-info">{{ $value->min_wbbm }}</button>
                                </td>
                                <td>
                                    <a type="button" href="/subrincian/{{ $value->id }}" class="btn btn-sm btn-info"><i
                                            class="fa fa-info"></i></a>
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
@endsection
