@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">

                <table id="example2" class="table table-bordered table-striped table-responsive">
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
                                @php
                                    // Ambil Nilai Pengungkit
                                    $nilai = $nilaiPengungkit->sum('nilai_sa');
                                @endphp
                                <td class="text-center">{{ round($nilai, 2) }}</td>
                                <td></td>
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
                                    <td> {{ $s->id }}
                                    </td>
                                    @php
                                        // Ambil Nilai
                                        // $nilai = $nilaiPengungkit->where('pilar_id', 'LIKE', '%' . $s->id . '%')->get();
                                        $nilai = App\Models\RekapPengungkit::where('rekapitulasi_id', $rekap->id)
                                            ->where('pilar_id', 'LIKE', '%' . $s->id . '%')
                                            ->get();
                                        
                                    @endphp
                                    {{ $nilai }}
                                    <td class="text-center">
                                        {{-- Jika nilai ada di database --}}
                                        {{-- @if ($nilai !== null)
                                            {{ round($nilai->nilai_sa, 2) }}
                                        @else
                                            0
                                        @endif --}}
                                    </td>
                                    <td></td>
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
                                        @php
                                            // Ambil Nilai Pengungkit
                                            $nilai = $p->RekapPengungkit->where('rekapitulasi_id', $rekap->id)->first();
                                        @endphp
                                        {{-- {{ $nilai }} --}}
                                        <td class="text-center">
                                            {{-- Jika nilai ada di database --}}
                                            @if ($nilai !== null)
                                                {{ round($nilai->nilai_sa, 2) }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td></td>
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
                                            @php
                                                $total_sa = 0;
                                                $jml_pertanyaan = $sp->pertanyaan->count();
                                                $penimbang = $sp->bobot / $jml_pertanyaan;
                                            @endphp
                                            @foreach ($sp->pertanyaan as $p)
                                                @php
                                                    // Self Assessment
                                                    $nilai = $p->SelfAssessment->where('rekapitulasi_id', $rekap->id)->sum('nilai');
                                                    $total_sa += $nilai * $penimbang;
                                                @endphp
                                            @endforeach
                                            <td class="text-center">{{ $total_sa }}</td>
                                            <td></td>
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
                                                            <td style="min-width: 400px">{{ $self->catatan }}</td>
                                                            <td>
                                                                @foreach ($self->dokumen as $d)
                                                                    <ul>
                                                                        <li> <a href="{{ asset('storage/' . $d->file) }}"
                                                                                target="__blank">{{ $d->name }}</a>
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    @endif
                                                @else
                                                    {{-- Buat FIeld Input --}}

                                                    <td></td>
                                                    <td>%</td>
                                                    @php
                                                        $SelfAssessment = $pt->SelfAssessment->where('rekapitulasi_id', $rekap->id);
                                                    @endphp
                                                    @if ($SelfAssessment->count() != 0)
                                                        @foreach ($SelfAssessment as $self)
                                                            <td>{{ $self->nilai * 100 }}%</td>
                                                            <td>{{ $self->nilai }}</td>
                                                            <td style="min-width: 400px">{{ $self->catatan }}</td>
                                                            <td>
                                                                @foreach ($self->dokumen as $d)
                                                                    <ul>
                                                                        <li> <a href="{{ asset('storage/' . $d->file) }}"
                                                                                target="__blank">{{ $d->name }}</a>
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    @endif
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
                                                        @if ($SelfAssessment->count() != 0)
                                                            @foreach ($SelfAssessment as $self)
                                                                @php
                                                                    $id = $o->id . $self->id;
                                                                @endphp
                                                                @foreach ($self->InputField->where('id', $id) as $input)
                                                                    <td> {{ $input->input_sa }}</td>
                                                                @endforeach
                                                            @endforeach
                                                        @else
                                                            <td>-</td>
                                                        @endif
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
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
