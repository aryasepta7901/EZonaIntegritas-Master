@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th colspan="7">Penilaian</th>
                            <th>Bobot</th>
                            <th>Penjelasan</th>
                            <th>Pilihan Jawaban</th>
                            <th>Jawaban</th>
                            <th>Nilai</th>
                            <th>Uraian Bukti Dukung</th>
                            <th>Link Bukti Dukung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rincian as $r)
                            <tr>
                                <td>{{ chr(64 + $loop->iteration) }}</td>
                                <td colspan="6">{{ $r->rincian }}</td>
                                <td class="text-center">{{ $r->bobot }}</td>
                                <td></td>
                                <td></td>

                            </tr>
                            @foreach ($r->SubRincian as $s)
                                <tr>
                                    <td></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td colspan="5">{{ $s->subRincian }}</td>
                                    <td class="text-center">{{ $s->bobot }}</td>
                                    <td></td>
                                    <td></td>


                                </tr>
                                @foreach ($s->Pilar as $p)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td colspan="4">{{ $p->pilar }}</td>
                                        <td class="text-center">{{ $p->bobot }}</td>
                                        <td></td>
                                        <td></td>


                                    </tr>
                                    @foreach ($p->SubPilar as $sp)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td colspan="3">{{ $sp->subPilar }}</td>
                                            <td class="text-center">{{ $sp->bobot }}</td>
                                            <td></td>
                                            <td></td>


                                        </tr>
                                        @foreach ($sp->pertanyaan as $pt)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ chr(64 + $loop->iteration) }}</td>
                                                <td colspan="2">{{ $pt->pertanyaan }}</td>

                                                <td></td>
                                                @if ($pt->opsi->first()->type == 'checkbox')
                                                    <td>
                                                        @foreach ($pt->opsi as $o)
                                                            {{ $o->rincian }} <br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @switch($pt->opsi->count())
                                                            @case(2)
                                                                <span>Ya/Tidak</span>
                                                            @break

                                                            @case(3)
                                                                <span>A/B/C</span>
                                                            @break

                                                            @case(4)
                                                                <span>A/B/C/D</span>
                                                            @break

                                                            @case(5)
                                                                <span>A/B/C/D/E</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    @php
                                                        $SelfAssessment = $pt->SelfAssessment->where('rekapitulasi_id', $rekap->id);
                                                    @endphp
                                                    @if ($SelfAssessment->count() != 0)
                                                        @foreach ($SelfAssessment as $self)
                                                            @if ($self->opsi->rincian == 'Tidak')
                                                                <td>{{ $self->opsi->rincian }}</td>
                                                            @else
                                                                <td>{{ substr($self->opsi->rincian, 0, 2) }}</td>
                                                            @endif
                                                            <td class="text-center">{{ $self->nilai }}</td>
                                                        @endforeach
                                                    @else
                                                        <td>Belum Diisi</td>
                                                        <td>Belum Diisi</td>
                                                    @endif
                                                @else
                                                    {{-- Buat FIeld Input --}}

                                                    <td></td>
                                                    <td>%</td>
                                                    <td>xx</td>
                                                @endif

                                            </tr>
                                            @if ($pt->opsi->first()->type == 'input')
                                                @foreach ($pt->opsi as $o)
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td> {{ $o->rincian }} </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>Jumlah</td>
                                                        @php
                                                            $SelfAssessment = $pt->SelfAssessment->where('rekapitulasi_id', $rekap->id);
                                                        @endphp

                                                        @foreach ($SelfAssessment as $self)
                                                            @php
                                                                $id = $o->id . $self->id;
                                                            @endphp

                                                            @foreach ($self->InputField->where('id', $id) as $input)
                                                                <td> {{ $input->input_sa }}</td>
                                                            @endforeach
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endif
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
