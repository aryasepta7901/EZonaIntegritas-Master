@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">

        <div class="card">
            <!-- /.card-header -->

            <div class="card-header d-flex justify-content-end">
                <button class="btn btn-primary " data-toggle="modal" data-target="#import"><i class="fa fa-file-import">
                    </i> Import Data</button>
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

                                <a href="/hasil/{{ $value->id }}" class="small-box-footer">Upload Nilai <i
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
            <div class="card-header d-flex justify-content-between">

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
                                {{-- HBA --}}
                                @php
                                    $hba = $data->where('pilar_id', 'HBA')->first();
                                @endphp
                                <td class="text-center">
                                    @if ($hba)
                                        <button class="badge badge-info">
                                            {{ $hba->nilai }}
                                        </button>
                                    @endif

                                </td>

                                {{-- HBB --}}
                                @php
                                    $hbb = $data->where('pilar_id', 'HBB')->first();
                                @endphp

                                <td class="text-center">
                                    @if ($hbb)
                                        <button class="badge badge-info">
                                            {{ $hbb->nilai }}
                                        </button>
                                    @endif
                                </td>

                                {{-- HPA --}}
                                @php
                                    $hpa = $data->where('pilar_id', 'HPA')->first();
                                @endphp

                                <td class="text-center">
                                    @if ($hpa)
                                        <button class="badge badge-info">
                                            {{ $hpa->nilai }}
                                        </button>
                                    @endif
                                </td>


                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data as $item)
                                    @php
                                        $total += $item->nilai; //total nilai
                                    @endphp
                                @endforeach
                                <td class="text-center"><button class="badge badge-info">{{ $total }}</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>


                </table>
            </div>

        </div>
    </div>

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
