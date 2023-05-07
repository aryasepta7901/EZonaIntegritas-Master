@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between ">
                <b>{{ $rekap->satker->nama_satker }}</b>
                <button class="btn btn-primary ml-auto" onclick="exportFile()">
                    <i class="fas fa-download"> </i> Excel
                </button>
            </div>

            <div class="card-body">
                <table id="excel" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th colspan="7">Penilaian</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Rincian --}}
                        @foreach ($rincian as $r)
                            <tr>
                                <th>{{ chr(64 + $loop->iteration) }}</th>
                                <th colspan="7">{{ $r->rincian }}</th>
                            </tr>
                            {{-- Subrincian --}}
                            @foreach ($r->SubRincian as $s)
                                <tr>
                                    <th></th>
                                    <th>{{ $loop->iteration }}</th>
                                    <th colspan="6">{{ $s->subRincian }}</th>
                                </tr>
                                {{-- Pilar --}}
                                @foreach ($s->Pilar as $p)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <th>{{ $loop->iteration }}</th>
                                        <th colspan="5">{{ $p->pilar }}</th>
                                    </tr>
                                    {{-- SubPilar --}}
                                    @foreach ($p->SubPilar as $sp)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>{{ $loop->iteration }}</th>
                                            <th colspan="4">{{ $sp->subPilar }}</th>
                                        </tr>
                                        {{-- Pertanyaan --}}
                                        @foreach ($sp->pertanyaan as $pt)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ chr(64 + $loop->iteration) }}</td>
                                                <td colspan="2">{{ $pt->pertanyaan }}</td>
                                                @php
                                                    // Ambil ID selfassessment
                                                    $SelfAssessment = $pt->SelfAssessment->where('rekapitulasi_id', $rekap->id)->first();
                                                @endphp
                                                <td>
                                                    @if ($SelfAssessment !== null)
                                                        @php
                                                            $DeskEvaluation = $DeskEvaluation->where('id', $SelfAssessment->id)->first();
                                                        @endphp
                                                        @if ($DeskEvaluation !== null)
                                                            {{ $DeskEvaluation->catatan_dl }}
                                                        @endif
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
