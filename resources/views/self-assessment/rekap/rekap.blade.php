@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" onclick="exportFile()">
                    <i class="fas fa-download"> Excel</i>
                </button>
            </div>

            <div class="card-body">
                <table id="excel" class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th colspan="7">Penilaian</th>
                            <th>Bobot</th>
                            <th>Penjelasan</th>
                            <th>Pilihan Jawaban</th>
                            <th>Jawaban</th>
                            <th>Nilai</th>
                            <th>%</th>
                            <th>Uraian Bukti Dukung</th>
                            <th>Link Bukti Dukung</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Rincian --}}
                        @foreach ($rincian as $r)
                            <tr>
                                <td>{{ chr(64 + $loop->iteration) }}</td>
                                <td colspan="6">{{ $r->rincian }}</td>
                                <td class="text-center">{{ $r->bobot }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @php
                                    // Ambil Nilai Pengungkit
                                    $nilai = $nilaiPengungkit->sum('nilai_sa');
                                    $persentase = (round($nilai, 2) * 100) / $r->bobot;
                                @endphp
                                <td class="text-center">{{ round($nilai, 2) }}</td>
                                <td class="text-center">{{ round($persentase, 2) }}%</td>
                                <td></td>
                                <td></td>
                            </tr>
                            {{-- Subrincian --}}
                            @foreach ($r->SubRincian as $s)
                                <tr>
                                    <td></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td colspan="5">{{ $s->subRincian }}</td>
                                    <td class="text-center">{{ $s->bobot }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @php
                                        // Ambil Nilai
                                        $nilai = App\Models\RekapPengungkit::where('rekapitulasi_id', $rekap->id)
                                            ->where('pilar_id', 'LIKE', '%' . $s->id . '%')
                                            ->sum('nilai_sa');
                                        $persentase = (round($nilai, 2) * 100) / $s->bobot;
                                    @endphp
                                    <td class="text-center">
                                        {{-- Jika nilai ada di database --}}
                                        @if ($nilai !== null)
                                            {{ round($nilai, 2) }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td class="text-center">{{ round($persentase, 2) }}%</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                {{-- Pilar --}}
                                @foreach ($s->Pilar as $p)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td colspan="4">{{ $p->pilar }}</td>
                                        <td class="text-center">{{ $p->bobot }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @php
                                            // Ambil Nilai Pengungkit
                                            $nilai = $p->RekapPengungkit->where('rekapitulasi_id', $rekap->id)->sum('nilai_sa');
                                            $persentase = (round($nilai, 2) * 100) / $p->bobot;
                                        @endphp
                                        <td class="text-center">
                                            {{ round($nilai, 2) }}
                                        </td>
                                        <td class="text-center">{{ round($persentase, 2) }}%</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    {{-- SubPilar --}}
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
                                                    $persentase = (round($total_sa, 2) * 100) / $sp->bobot;
                                                    
                                                @endphp
                                            @endforeach
                                            <td class="text-center">{{ round($total_sa, 2) }}</td>
                                            <td class="text-center">{{ round($persentase, 2) }}%</td>
                                            <td></td>
                                            <td></td>
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
                                                    {{-- Jawaban Opsi Checkbox --}}
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
                                                            <td></td>
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
                                                        <td></td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    @endif
                                                @else
                                                    {{-- Jawaban   FIeld Input --}}
                                                    <td>{{ $pt->info }}</td>
                                                    <td>%</td>
                                                    @php
                                                        $SelfAssessment = $pt->SelfAssessment->where('rekapitulasi_id', $rekap->id);
                                                    @endphp
                                                    @if ($SelfAssessment->count() != 0)
                                                        {{-- Field Input yang sudah diisi --}}
                                                        @foreach ($SelfAssessment as $self)
                                                            <td class="text-center">{{ $self->nilai * 100 }}%</td>
                                                            <td class="text-center">{{ $self->nilai }}</td>
                                                            <td></td>
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
                                                        {{-- Field Input yang belum diiisi --}}
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    @endif
                                                @endif

                                            </tr>
                                            {{-- Opsi Input --}}
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
