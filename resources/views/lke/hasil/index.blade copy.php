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
@endsection
