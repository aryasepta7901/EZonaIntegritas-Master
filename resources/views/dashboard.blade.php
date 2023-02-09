@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <p class="text-center">Selamat Datang Kembali {{ auth()->user()->name }}
                    ({{ auth()->user()->satker->nama_satker }})
                </p>


            </div>
            <div class="card-body">

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
