@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ auth()->user()->satker->nama_satker }}</h3>
                <p class="text-muted text-center">Pengajuan Zona Integritas</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>{{ $rekap->satker->nama_satker }}</b> <a class="float-right">{{ $rekap->predikat }}</a>

                        {{-- Sepertinya cukup nilai pengungkit saja yang ditampilkan --}}
                        {{-- @php 
                            $total = round($nilaiPengungkit->sum('nilai_sa'), 2) + $nilaiHasil;
                        @endphp --}}
                        <p>Nilai Self Assessment: {{ round($nilaiPengungkit, 2) }}</p>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-lg-8">
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

        <div class="card">
            <div class="card-header">
                Upload Surat Pengantar
            </div>
            <div class="card-body">
                <form action="/satker/rekapitulasi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $rekap->id }}" name="id">
                    <input type="hidden" name="satker_id" value="{{ $rekap->satker_id }}">
                    <input type="hidden" name="nilai" value="{{ round($nilaiPengungkit, 2) }}">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload" name="surat"
                            accept="application/pdf">
                        <label class="custom-file-label" for="upload">
                            Upload</label>
                    </div>
                    @if ($rekap->LHE->surat_pengantar_kabkota)
                        <table class="table table-bordered table-striped mt-3">
                            <thead>
                                <tr class="text-center">
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal"
                                            data-target="#surat_pengantar"><i class="fas fa-file">
                                            </i></button>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    @endif

            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end mr-3">

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
    {{-- Informasi --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <b>{{ auth()->user()->satker->nama_satker }}</b>

                    <button class="btn btn-primary " data-toggle="modal" data-target="#download"><i class="fas fa-download">
                        </i> Download Template
                    </button>

                </div>
            </div>
            <div class="card-body">
                <p>Berikut dilampirkan template surat pengantar BPS Kab/Kota</p>
                <p>Langkah-Langkah:</p>
                <ol>
                    <li>Download Templete <badge class="text-info">.docx</badge>
                    </li>
                    <li>Sesuaikan dan ubah kalimat yang <badge class="text-danger">warna merah</badge>
                    </li>
                    <li>Print surat dan berikan tanda tangan kepala BPS Kab/Kota</li>
                    <li>Scan surat dan upload ke website kembali dengan format <badge class="text-info">.pdf</badge>
                    </li>
                </ol>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    {{-- Informasi Rekapitulasi Satker --}}
    <div class="col-lg-12">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                            href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                            aria-selected="true">Rekap 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                            href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                            aria-selected="false">Rekap 2</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">
                        <button class="btn btn-primary" onclick="exportFile()">
                            <i class="fas fa-download"> </i>Excel
                        </button>
                        <hr>
                        <table id="excel" class="table table-bordered  table-responsive ">
                            <thead>
                                <tr style="background-color:">
                                    <th colspan="4">Penilaian</th>
                                    <th>Bobot</th>
                                    <th>Nilai</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Rincian --}}
                                @foreach ($rincian as $r)
                                    <tr>
                                        <th>{{ chr(64 + $loop->iteration) }}</th>
                                        <th colspan="3">{{ Str::upper($r->rincian) }}</th>
                                        <td class="text-center">{{ $r->bobot }}</td>
                                        @php
                                            // Ambil Nilai Pengungkit
                                            $nilai = $nilaiPengungkit;
                                            $persentase = (round($nilai, 2) * 100) / $r->bobot;
                                        @endphp
                                        <td class="text-center">{{ round($nilai, 2) }}</td>
                                        <td class="text-center">{{ round($persentase, 2) }}</td>

                                    </tr>
                                    {{-- Subrincian --}}
                                    @foreach ($r->SubRincian as $s)
                                        <tr>
                                            <td></td>
                                            <th>{{ $loop->iteration }}</th>
                                            <th colspan="2">{{ Str::upper($s->subRincian) }}</th>
                                            <td class="text-center">{{ $s->bobot }}</td>
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
                                        </tr>
                                        {{-- Pilar --}}
                                        @foreach ($s->Pilar as $p)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::upper($p->pilar) }}</td>
                                                <td class="text-center">{{ $p->bobot }}</td>
                                                @php
                                                    // Ambil Nilai Pengungkit
                                                    $nilai = $p->RekapPengungkit->where('rekapitulasi_id', $rekap->id)->sum('nilai_sa');
                                                    $persentase = (round($nilai, 2) * 100) / $p->bobot;
                                                @endphp
                                                <td class="text-center">
                                                    {{ round($nilai, 2) }}
                                                </td>
                                                <td class="text-center">{{ round($persentase, 2) }}%</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-three-profile-tab">
                        <button class="btn btn-primary" onclick="exportFile2()">
                            <i class="fas fa-download"> </i>Excel
                        </button>
                        <hr>
                        <table id="excel2" class="table table-bordered  table-responsive ">
                            <thead>
                                <tr style="background-color:">
                                    <th colspan="5">Penilaian</th>
                                    <th>Bobot</th>
                                    <th>Nilai</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Rincian --}}
                                @foreach ($rincian as $r)
                                    <tr>
                                        <th>{{ chr(64 + $loop->iteration) }}</th>
                                        <th colspan="4">{{ Str::upper($r->rincian) }}</th>
                                        <td class="text-center">{{ $r->bobot }}</td>
                                        @php
                                            // Ambil Nilai Pengungkit
                                            $nilai = $nilaiPengungkit;
                                            $persentase = (round($nilai, 2) * 100) / $r->bobot;
                                        @endphp
                                        <td class="text-center">{{ round($nilai, 2) }}</td>
                                        <td class="text-center">{{ round($persentase, 2) }}%</td>

                                    </tr>
                                    {{-- Subrincian --}}
                                    @foreach ($r->SubRincian as $s)
                                        <tr>
                                            <td></td>
                                            <th>{{ $loop->iteration }}</th>
                                            <th colspan="3">{{ Str::upper($s->subRincian) }}</th>
                                            <td class="text-center">{{ $s->bobot }}</td>
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
                                        </tr>
                                        {{-- Pilar --}}
                                        @foreach ($s->Pilar as $p)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <th>{{ $loop->iteration }}</th>
                                                <th colspan="2">{{ Str::upper($p->pilar) }}</th>
                                                <td class="text-center">{{ $p->bobot }}</td>
                                                @php
                                                    // Ambil Nilai Pengungkit
                                                    $nilai = $p->RekapPengungkit->where('rekapitulasi_id', $rekap->id)->sum('nilai_sa');
                                                    $persentase = (round($nilai, 2) * 100) / $p->bobot;
                                                @endphp
                                                <td class="text-center">
                                                    {{ round($nilai, 2) }}
                                                </td>
                                                <td class="text-center">{{ round($persentase, 2) }}%</td>
                                            </tr>
                                            {{-- SubPilar --}}
                                            @foreach ($p->SubPilar as $sp)
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $sp->subPilar }}</td>
                                                    <td class="text-center">{{ $sp->bobot }}</td>
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
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="surat_pengantar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Surat Pengantar
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                            src="{{ asset('storage/' . $rekap->LHE->surat_pengantar_kabkota) }}" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Download --}}
    <div class="modal fade" id="download">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Download Template</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="/satker/surat/cetak" method="post">
                    @csrf
                    <input type="hidden" value="{{ round($nilaiPengungkit, 2) }}" name="nilaisa">
                    <input type="hidden" value="{{ $rekap->satker->nama_satker }}" name="satker">
                    <input type="hidden" value="{{ $rekap->satker_id }}" name="satker_id">
                    <input type="hidden" value="{{ $rekap->id }}" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_surat">Nomor Surat</label>
                            <input type="text" class="form-control @error('no_surat') is-invalid  @enderror"
                                id="no_surat" name="no_surat" value="{{ old('no_surat') }}">
                            @error('no_surat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Download</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
