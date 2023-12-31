@extends('layouts.backEnd.main')

@section('content')
    @if ($rekap->status == 4)
        {{-- Jika status rekapitulasi dikembalikan dari TPI --}}
        @if (
            ($pengawasan->status == 0 && auth()->user()->level_id == 'AT') ||
                ($pengawasan->status == 1 && auth()->user()->level_id == 'KT') ||
                ($pengawasan->status == 2 && auth()->user()->level_id == 'DL'))
            <div class="col-lg-12 mb-3 d-flex justify-content-between">
                <button class="btn btn-info" data-toggle="modal" data-target="#lihat"><i class="fa fa-eye">
                    </i> Lihat </button>
            </div>
        @endif


        <div class="modal fade" id="lihat">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($pengawasan->tahap == 1)
                            <h4 class="modal-title">Pengisian Self-Assessment</h4>
                        @else
                            <h4 class="modal-title">Perubahan Hasil Evaluasi Tahap 1 </h4>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-bordered table-striped table-responsive-lg">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th>Evaluasi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pilar->subPilar as $sp)
                                    @foreach ($sp->pertanyaan as $value)
                                        @php
                                            $selfAssessment = $value->SelfAssessment->where('rekapitulasi_id', $rekap->id)->first();
                                        @endphp
                                        <tr>
                                            @if ($selfAssessment)
                                                @php
                                                    $deskEvaluation = $selfAssessment->DeskEvaluation->first();
                                                @endphp
                                                <form action="/tpi/evaluasi" method="post">
                                                    @csrf
                                                    <input type="hidden" name="rekap" value="{{ $rekap->id }}">
                                                    <input type="hidden" name="pilar" value="{{ $pilar->id }}">
                                                    <input type="hidden" name="pertanyaan" value="{{ $value->id }}">
                                                    @php
                                                        if ($pengawasan->status == 1) {
                                                            // Jika ketua tim
                                                            $check = $deskEvaluation->updated_kt;
                                                        } elseif ($pengawasan->status == 2) {
                                                            // Jika dalnis
                                                            $check = $deskEvaluation->updated_dl;
                                                        } elseif ($pengawasan->status == 0) {
                                                            // Jika anggota tim
                                                            $check = 0;
                                                        }
                                                    @endphp
                                                    @if ($deskEvaluation != null)
                                                        {{-- Jika SA tidak terdapat perubahan --}}
                                                        @if ($selfAssessment->updated_at < $deskEvaluation->created_at)
                                                            <td class="">
                                                                <button class="btn btn-link" type="submit" name="scroll"
                                                                    value="scroll">
                                                                    {{ $value->pertanyaan }}</button>

                                                            </td>
                                                            <td class="text-center ">
                                                                @if ($pengawasan->status == 0)
                                                                    <button class="badge badge-info badge-sm"> <i
                                                                            class="fas fa-check"></i></button>
                                                                @endif
                                                                @if ($pengawasan->tahap == 1)
                                                                    {{-- Jika evaluasi tahap 1 --}}
                                                                    @if ($check == 1 || $check == 2)
                                                                        <button class="badge badge-info badge-sm"> <i
                                                                                class="fas fa-check"></i></button>
                                                                    @endif
                                                                @elseif($pengawasan->tahap == 2)
                                                                    {{-- Jika evaluasi tahap 2 --}}
                                                                    @if ($check == 2)
                                                                        <button class="badge badge-info badge-sm"> <i
                                                                                class="fas fa-check"></i></button>
                                                                    @endif
                                                                @endif


                                                            </td>
                                                        @endif
                                                        {{-- Lihat perubahan pada SA --}}
                                                        @if ($selfAssessment->updated_at > $deskEvaluation->created_at)
                                                            <td>
                                                                <button class="btn btn-link" type="submit" name="scroll"
                                                                    value="scroll">
                                                                    {{ $value->pertanyaan }}</button>

                                                            </td>
                                                            @if ($selfAssessment->updated_at < $deskEvaluation->updated_at)
                                                                <td class="text-center">
                                                                    @if ($pengawasan->status == 0)
                                                                        <button class="badge badge-info badge-sm"> <i
                                                                                class="fas fa-check"></i></button>
                                                                    @endif
                                                                    @if ($pengawasan->tahap == 1)
                                                                        {{-- Jika evaluasi tahap 1 --}}
                                                                        @if ($check == 1)
                                                                            <button class="badge badge-info badge-sm"> <i
                                                                                    class="fas fa-check"></i></button>
                                                                        @endif
                                                                    @elseif($pengawasan->tahap == 2)
                                                                        {{-- Jika evaluasi tahap 2 --}}
                                                                        @if ($check == 2)
                                                                            <button class="badge badge-info badge-sm"> <i
                                                                                    class="fas fa-check"></i></button>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        @endif
                                                    @else
                                                        {{-- Jika SA baru create --}}
                                                        <td class="">
                                                            <button class="btn btn-link" type="submit" name="scroll"
                                                                value="scroll">
                                                                {{ $value->pertanyaan }}</button>
                                                        </td>
                                                        <td></td>
                                                    @endif
                                                </form>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endif
    <div class="col-md-8 col-lg-12">
        <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
            @foreach ($subPilar as $value)
                @php
                    // Ambil data  selfAssessment satker yang sudah dijawab , ini digunakan untuk mengecek apakah subPilar tersebut terjawab atau belum, jika belum maka TPI tidak perlu melakukan Desk Evaluation
                    $SatkerJawab = App\Models\SelfAssessment::where('rekapitulasi_id', $rekap->id)
                        ->where('pertanyaan_id', 'LIKE', '%' . $value->id . '%')
                        ->first();
                @endphp
                @php
                    // Perhitungan Nilai setiap Pertanyaan
                    $jml_pertanyaan = $value->pertanyaan->count();
                    $penimbang = $value->bobot / $jml_pertanyaan;
                    $total_sa = 0;
                    $total_at = 0;
                    $total_kt = 0;
                    $total_dl = 0;
                @endphp
                @foreach ($value->pertanyaan as $p)
                    @php
                        $nilai_sa = $p->SelfAssessment->where('rekapitulasi_id', $rekap->id)->sum('nilai');
                        $total_sa += $nilai_sa * $penimbang;
                    @endphp
                    @foreach ($p->SelfAssessment->where('rekapitulasi_id', $rekap->id) as $s)
                        @php
                            $nilai_at = $s->DeskEvaluation->sum('nilai_at');
                            $total_at += $nilai_at * $penimbang;
                            $nilai_kt = $s->DeskEvaluation->sum('nilai_kt');
                            $total_kt += $nilai_kt * $penimbang;
                            $nilai_dl = $s->DeskEvaluation->sum('nilai_dl');
                            $total_dl += $nilai_dl * $penimbang;
                        @endphp
                    @endforeach
                @endforeach
                <div class="card">
                    <div class="card-header p-0" id="heading{{ $loop->iteration }}">
                        <h2 class="mb-0">
                            <button href="#{{ $value->id }}"
                                class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link button"
                                data-parent="#accordion" data-toggle="collapse" aria-expanded=""
                                aria-controls="{{ $value->id }}">
                                <p class="mb-0">{{ $value->subPilar }} ({{ $value->bobot }})</p>
                                <div class="d-flex justify-content-between ">
                                    <i class="fa " aria-hidden="true"></i>

                                </div>
                            </button>
                        </h2>
                    </div>
                    <div class="collapse" id="{{ $value->id }}" role="tabpanel"
                        aria-labelledby="heading{{ $loop->iteration }}">
                        @if ($SatkerJawab != null)
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Pertanyaan</h3>
                                    </div>
                                    <hr>

                                    <div class="card-body">
                                        <table id="" class="table table-bordered table-responsive table-striped">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="d-flex justify-content-between">
                                                            Self-Assessment
                                                            <button class="badge badge-info btn-sm">Nilai :
                                                                {{ round($total_sa, 2) }}</button>
                                                        </div>
                                                    </th>
                                                    @if ($rekap->status == 4 || $rekap->status == 5 || $rekap->status == 6 || $rekap->status == 7)
                                                        @if ($rekap->LHE->surat_pengantar_prov != '')
                                                            <th>
                                                                <div class="d-flex justify-content-between">
                                                                    Desk-Evaluation
                                                                    <button class="badge badge-info btn-sm">Nilai AT :
                                                                        {{ round($total_at, 2) }}</button>
                                                                    <button class="badge badge-info btn-sm">Nilai KT :
                                                                        {{ round($total_kt, 2) }}</button>
                                                                    <button class="badge badge-info btn-sm">Nilai PT :
                                                                        {{ round($total_dl, 2) }}</button>
                                                                </div>

                                                            </th>
                                                        @endif
                                                    @endif

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($value->pertanyaan as $value)
                                                    @php
                                                        $selfAssessment = $value->SelfAssessment->where('rekapitulasi_id', $rekap->id)->first();
                                                    @endphp

                                                    @if ($selfAssessment != null)
                                                        <tr class="rowAccordion">
                                                            {{-- Self Assessment --}}
                                                            {{-- View --}}
                                                            <form method="POST">
                                                                <td style="min-width: 500px;">
                                                                    @php
                                                                        
                                                                        $deskEvaluation = $DeskEvaluation->where('id', $selfAssessment->id)->first();
                                                                    @endphp
                                                                    @if ($deskEvaluation != null)
                                                                        @if ($pengawasan->tahap == 2)
                                                                            @if ($selfAssessment->updated_at > $deskEvaluation->updated_at)
                                                                                {{-- Jika Terdapat Perubahan pada Penilaian Evaluasi Tahap 1 --}}
                                                                                <div class="col-lg-12">
                                                                                    <div
                                                                                        class="alert alert-info  alert-dismissible">
                                                                                        <h5><i
                                                                                                class="icon fas fa-info"></i>
                                                                                            Perubahan!
                                                                                        </h5>
                                                                                        Terdapat Perubahan pada Penilaian
                                                                                        Evaluasi Tahap 1
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <label
                                                                                for="pertanyaan">{{ $value->pertanyaan }}</label>
                                                                            @foreach ($value->opsi as $item)
                                                                                @if ($item->type == 'checkbox')
                                                                                    <div class="form-check ml-4">
                                                                                        <input readonly
                                                                                            @if ($selfAssessment->opsi_id == $item->id) checked @endif
                                                                                            class="form-check-input"
                                                                                            type="radio" name="opsi_id"
                                                                                            value="{{ $item->id }}">
                                                                                        <label
                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                    </div>
                                                                                @elseif($item->type == 'input')
                                                                                    @php
                                                                                        $self = $selfAssessment->InputField->where('opsi_id', $item->id)->first();
                                                                                    @endphp
                                                                                    <p for="input">
                                                                                        {{ $item->rincian }}
                                                                                    </p>
                                                                                    <input readonly type="number"
                                                                                        min="0"
                                                                                        class="form-control"
                                                                                        id="{{ $item->id }}"
                                                                                        name="input[]"
                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                        value="{{ $self->input_sa }}">
                                                                                @endif
                                                                            @endforeach
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="catatan">Catatan</label>
                                                                            <textarea readonly class="form-control" rows="4" name="catatan">{{ old('catatan', $selfAssessment->catatan) }} </textarea>
                                                                        </div>
                                                                        {{-- File Utama --}}
                                                                        <label for="catatan">Dokumen</label>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>No</th>
                                                                                    <th>Nama Dokumen</th>
                                                                                    <th>File</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($value->dokumen as $item)
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                        <td style="min-width: 200px">
                                                                                            {{ $item->dokumen }}
                                                                                            <input type="hidden"
                                                                                                name="id{{ $loop->index }}"
                                                                                                value="{{ $item->id }}">
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            @php
                                                                                                $file = $item->file->where('selfassessment_id', $selfAssessment->id);
                                                                                            @endphp
                                                                                            @if ($file->count() != 0)
                                                                                                @foreach ($file as $f)
                                                                                                    <button type="button"
                                                                                                        class="btn btn-info btn-sm"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#view{{ $f->id }}"><i
                                                                                                            class="fas fa-file"></i></button>
                                                                                                    {{-- Modal View File Utama --}}
                                                                                                    <div class="modal fade"
                                                                                                        id="view{{ $f->id }}">
                                                                                                        <div
                                                                                                            class="modal-dialog modal-lg">
                                                                                                            <div
                                                                                                                class="modal-content">
                                                                                                                <div
                                                                                                                    class="modal-header">
                                                                                                                    <h4
                                                                                                                        class="modal-title">
                                                                                                                        {{ $f->name }}
                                                                                                                    </h4>
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        class="close"
                                                                                                                        data-dismiss="modal"
                                                                                                                        aria-label="Close">
                                                                                                                        <span
                                                                                                                            aria-hidden="true">&times;</span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="modal-body">
                                                                                                                    <div
                                                                                                                        class="embed-responsive embed-responsive-16by9">
                                                                                                                        <iframe
                                                                                                                            class="embed-responsive-item"
                                                                                                                            src="{{ asset('storage/' . $f->file) }}"
                                                                                                                            allowfullscreen></iframe>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="modal-footer justify-content-between">
                                                                                                                    <button
                                                                                                                        type="button"
                                                                                                                        class="btn btn-default"
                                                                                                                        data-dismiss="modal">Close</button>

                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- /.modal-content -->
                                                                                                        </div>
                                                                                                        <!-- /.modal-dialog -->
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            @else
                                                                                                <small>No Data</small>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach

                                                                            </tbody>
                                                                        </table>
                                                                        {{-- File Utama --}}
                                                                        {{-- File Tambahan --}}
                                                                        @php
                                                                            $file = $value->file->where('selfassessment_id', $selfAssessment->id);
                                                                        @endphp
                                                                        @if ($file->count() != 0)
                                                                            <label for="catatan">Dokumen
                                                                                Tambahan</label>
                                                                            <table
                                                                                class="table table-bordered table-striped mt-3">
                                                                                <thead>
                                                                                    <tr class="text-center">
                                                                                        <th>No</th>
                                                                                        <th>Nama Dokumen</th>
                                                                                        <th>File</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($file as $item)
                                                                                        <tr>
                                                                                            <td>{{ $loop->iteration }}
                                                                                            </td>
                                                                                            <td style="min-width: 200px">
                                                                                                {{ $item->name }}
                                                                                                <input type="hidden"
                                                                                                    name="upload_id{{ $loop->index }}"
                                                                                                    value="{{ $item->id }}">
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                <button type="button"
                                                                                                    class="btn btn-info btn-sm"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#view{{ $item->id }}"><i
                                                                                                        class="fas fa-file"></i></button>
                                                                                                {{-- Modal View File Tambahan --}}
                                                                                                <div class="modal fade"
                                                                                                    id="view{{ $item->id }}">
                                                                                                    <div
                                                                                                        class="modal-dialog modal-lg">
                                                                                                        <div
                                                                                                            class="modal-content">
                                                                                                            <div
                                                                                                                class="modal-header">
                                                                                                                <h4
                                                                                                                    class="modal-title">
                                                                                                                    {{ $item->name }}
                                                                                                                </h4>
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="close"
                                                                                                                    data-dismiss="modal"
                                                                                                                    aria-label="Close">
                                                                                                                    <span
                                                                                                                        aria-hidden="true">&times;</span>
                                                                                                                </button>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="modal-body">
                                                                                                                <div
                                                                                                                    class="embed-responsive embed-responsive-16by9">
                                                                                                                    <iframe
                                                                                                                        class="embed-responsive-item"
                                                                                                                        src="{{ asset('storage/' . $item->file) }}"
                                                                                                                        allowfullscreen></iframe>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="modal-footer justify-content-between">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    class="btn btn-default"
                                                                                                                    data-dismiss="modal">Close</button>

                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <!-- /.modal-content -->
                                                                                                    </div>
                                                                                                    <!-- /.modal-dialog -->
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                            {{-- File Tambahan --}}
                                                                        @endif
                                                                    </div>
                                                                    <hr>
                                                                </td>

                                                            </form>
                                                            {{-- Desk Evaluation TPI --}}
                                                            @php
                                                                $deskEvaluation = $DeskEvaluation->where('id', $selfAssessment->id)->first();
                                                            @endphp
                                                            @if ($rekap->status == 4 || $rekap->status == 5 || $rekap->status == 6 || $rekap->status == 7)
                                                                {{-- Cek Apakah Surat rekomendasi sudah diupload atau belum --}}
                                                                @if ($rekap->LHE->surat_pengantar_prov != '')
                                                                    <td style="min-width:500px;"
                                                                        id="{{ $value->id }}">
                                                                        {{-- Anggota Tim --}}
                                                                        {{-- Update --}}
                                                                        @if (auth()->user()->level_id == 'AT')
                                                                            @if ($deskEvaluation != null)
                                                                                <div class="card-body">
                                                                                    <form
                                                                                        action="/tpi/evaluasi/{{ $deskEvaluation->id }}"
                                                                                        method="post">
                                                                                        @method('put')
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="anggota">Anggota
                                                                                                Tim</label>
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->id }}"
                                                                                                name="rekapitulasi_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pilar->id }}"
                                                                                                name="pilar_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $penimbang }}"
                                                                                                name="penimbang">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pengawasan->id }}"
                                                                                                name="pengawasan">
                                                                                            <input type="hidden"
                                                                                                name="pertanyaan_id"
                                                                                                value="{{ $value->id }}">
                                                                                            <input type="hidden"
                                                                                                name="id_self"
                                                                                                value="{{ $selfAssessment->id }}">

                                                                                            @foreach ($value->opsi as $item)
                                                                                                @if ($item->type == 'checkbox')
                                                                                                    <div
                                                                                                        class="form-check ml-4">
                                                                                                        <input
                                                                                                            class="form-check-input"
                                                                                                            type="radio"
                                                                                                            name="jawaban_at"
                                                                                                            value="{{ $item->id }}"
                                                                                                            @if ($pengawasan->status != 0 || auth()->user()->level_id != 'AT') disabled @endif
                                                                                                            @if ($deskEvaluation->jawaban_at == $item->id) checked @endif>

                                                                                                        <label
                                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                                    </div>
                                                                                                @elseif($item->type == 'input')
                                                                                                    <p for="input">
                                                                                                        {{ $item->rincian }}
                                                                                                    </p>

                                                                                                    @php
                                                                                                        $desk = $deskEvaluation->InputField->where('opsi_id', $item->id)->first();
                                                                                                    @endphp
                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->id }}"
                                                                                                        name="opsi{{ $loop->index }}">
                                                                                                    <input type="number"
                                                                                                        min="0"
                                                                                                        required
                                                                                                        class="form-control"
                                                                                                        name="input[]"
                                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                                        @if ($pengawasan->status != 0 || auth()->user()->level_id != 'AT') disabled @endif
                                                                                                        value="{{ $desk->input_at }}">
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="catatan">Catatan</label>
                                                                                            <textarea class="form-control @error('catatan_at') is-invalid  @enderror" rows="4" name="catatan_at"
                                                                                                @if ($pengawasan->status != 0 || auth()->user()->level_id != 'AT') disabled @endif>{{ old('catatan_at', $deskEvaluation->catatan_at) }}  </textarea>
                                                                                            @error('catatan_at')
                                                                                                <div class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-start">
                                                                                            @if ($rekap->status == 4)
                                                                                                @if ($pengawasan->status == 0 && auth()->user()->level_id == 'AT')
                                                                                                    <button type="submit"
                                                                                                        class="submit-button btn btn-primary"
                                                                                                        name="submit_at"
                                                                                                        value="at"><i
                                                                                                            class="fas fa-save"></i>
                                                                                                        Simpan
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            @else
                                                                                {{-- Create --}}
                                                                                <div class="card-body">
                                                                                    <form action="/tpi/evaluasi"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="anggota">Anggota
                                                                                                Tim</label>
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->satker_id }}"
                                                                                                name="satker_id">
                                                                                            <input type="hidden"
                                                                                                name="pertanyaan_id"
                                                                                                value="{{ $value->id }}">
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->id }}"
                                                                                                name="rekapitulasi_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pilar->id }}"
                                                                                                name="pilar_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $penimbang }}"
                                                                                                name="penimbang">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pengawasan->id }}"
                                                                                                name="pengawasan">
                                                                                            <input type="hidden"
                                                                                                name="id_self"
                                                                                                value="{{ $selfAssessment->id }}">
                                                                                            @foreach ($value->opsi as $item)
                                                                                                @if ($item->type == 'checkbox')
                                                                                                    <div
                                                                                                        class="form-check ml-4">
                                                                                                        <input
                                                                                                            class="form-check-input"
                                                                                                            type="radio"
                                                                                                            name="jawaban_at"
                                                                                                            value="{{ $item->id }}"
                                                                                                            @if ($pengawasan->status != 0 || auth()->user()->level_id != 'AT') disabled @endif>
                                                                                                        <label
                                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                                    </div>
                                                                                                @elseif($item->type == 'input')
                                                                                                    <p for="input">
                                                                                                        {{ $item->rincian }}
                                                                                                    </p>
                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->id }}"
                                                                                                        name="opsi{{ $loop->index }}">
                                                                                                    <input type="number"
                                                                                                        min="0"
                                                                                                        required
                                                                                                        class="form-control"
                                                                                                        name="input[]"
                                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                                        @if ($pengawasan->status != 0 || auth()->user()->level_id != 'AT') disabled @endif>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="catatan">Catatan</label>
                                                                                            <textarea class="form-control @error('catatan_at') is-invalid  @enderror" rows="4" name="catatan_at"
                                                                                                @if ($pengawasan->status != 0 || auth()->user()->level_id != 'AT') disabled @endif>{{ old('catatan_at') }} </textarea>
                                                                                            @error('catatan_at')
                                                                                                <div class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-start">
                                                                                            @if ($rekap->status == 4)
                                                                                                @if ($pengawasan->status == 0 && auth()->user()->level_id == 'AT')
                                                                                                    <button type="submit"
                                                                                                        class="submit-button btn btn-primary"
                                                                                                        name="submit_at"
                                                                                                        value="at"><i
                                                                                                            class="fas fa-save"></i>
                                                                                                        Simpan
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                        {{-- Ketua Tim --}}
                                                                        @if (auth()->user()->level_id == 'KT')
                                                                            @if ($deskEvaluation != null)
                                                                                @if ($pengawasan->tahap == 1 && $deskEvaluation->updated_kt == 0)
                                                                                    <div
                                                                                        class="col-lg-12 mb-3 d-flex justify-content-end">
                                                                                        <div
                                                                                            class="alert alert-info alert-dismissible">
                                                                                            <h5><i
                                                                                                    class="icon fas fa-info"></i>
                                                                                                Note</h5>
                                                                                            Jawaban dibawah ini adalah
                                                                                            Hasil
                                                                                            dari Anggota Tim, Harap
                                                                                            Update
                                                                                            untuk
                                                                                            menandakan anda ikut
                                                                                            evaluasi
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if ($pengawasan->tahap == 2 && $deskEvaluation->updated_kt != 2)
                                                                                    <div
                                                                                        class="col-lg-12 mb-3 d-flex justify-content-end">
                                                                                        <div
                                                                                            class="alert alert-info alert-dismissible">
                                                                                            <h5><i
                                                                                                    class="icon fas fa-info"></i>
                                                                                                Note</h5>
                                                                                            Jawaban dibawah ini adalah
                                                                                            Hasil
                                                                                            dari Anggota Tim, Harap
                                                                                            Update
                                                                                            untuk
                                                                                            menandakan anda ikut
                                                                                            evaluasi
                                                                                        </div>
                                                                                    </div>
                                                                                @endif


                                                                                <div class="card-body">
                                                                                    <form
                                                                                        action="/tpi/evaluasi/{{ $deskEvaluation->id }}"
                                                                                        method="post">
                                                                                        @method('put')
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="anggota">Ketua
                                                                                                Tim</label>
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->id }}"
                                                                                                name="rekapitulasi_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pilar->id }}"
                                                                                                name="pilar_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $penimbang }}"
                                                                                                name="penimbang">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pengawasan->id }}"
                                                                                                name="pengawasan">
                                                                                            <input type="hidden"
                                                                                                name="pertanyaan_id"
                                                                                                value="{{ $value->id }}">
                                                                                            <input type="hidden"
                                                                                                name="id_self"
                                                                                                value="{{ $selfAssessment->id }}">


                                                                                            @foreach ($value->opsi as $item)
                                                                                                @if ($item->type == 'checkbox')
                                                                                                    <div
                                                                                                        class="form-check ml-4">
                                                                                                        <input
                                                                                                            class="form-check-input"
                                                                                                            type="radio"
                                                                                                            name="jawaban_kt"
                                                                                                            value="{{ $item->id }}"
                                                                                                            @if ($pengawasan->status != 1 || auth()->user()->level_id != 'KT') disabled @endif
                                                                                                            @if ($deskEvaluation->jawaban_kt == $item->id) checked @endif>

                                                                                                        <label
                                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                                    </div>
                                                                                                @elseif($item->type == 'input')
                                                                                                    <p for="input">
                                                                                                        {{ $item->rincian }}
                                                                                                    </p>
                                                                                                    @php
                                                                                                        $desk = $deskEvaluation->InputField->where('opsi_id', $item->id)->first();
                                                                                                    @endphp
                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->id }}"
                                                                                                        name="opsi{{ $loop->index }}">
                                                                                                    <input type="number"
                                                                                                        min="0"
                                                                                                        required
                                                                                                        class="form-control"
                                                                                                        name="input[]"
                                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                                        @if ($pengawasan->status != 1 || auth()->user()->level_id != 'KT') disabled @endif
                                                                                                        value="{{ $desk->input_kt }}">
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="catatan">Catatan</label>
                                                                                            <textarea class="form-control @error('catatan_kt') is-invalid  @enderror" rows="4" name="catatan_kt"
                                                                                                @if ($pengawasan->status != 1 || auth()->user()->level_id != 'KT') disabled @endif>{{ old('catatan_kt', $deskEvaluation->catatan_kt) }}  </textarea>
                                                                                            @error('catatan_kt')
                                                                                                <div class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-start">
                                                                                            @if ($rekap->status == 4)
                                                                                                @if ($pengawasan->status == 1 && auth()->user()->level_id == 'KT')
                                                                                                    <button type="submit"
                                                                                                        class="submit-button btn btn-primary"
                                                                                                        name="submit_kt"
                                                                                                        value="kt"><i
                                                                                                            class="fas fa-save"></i>
                                                                                                        Update
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            @else
                                                                                {{-- Create --}}
                                                                                <div class="card-body">
                                                                                    <form action="/tpi/evaluasi"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label for="anggota">Ketua
                                                                                                Tim</label>
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->satker_id }}"
                                                                                                name="satker_id">
                                                                                            <input type="hidden"
                                                                                                name="pertanyaan_id"
                                                                                                value="{{ $value->id }}">
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->id }}"
                                                                                                name="rekapitulasi_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pilar->id }}"
                                                                                                name="pilar_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $penimbang }}"
                                                                                                name="penimbang">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pengawasan->id }}"
                                                                                                name="pengawasan">
                                                                                            <input type="hidden"
                                                                                                name="id_self"
                                                                                                value="{{ $selfAssessment->id }}">
                                                                                            @foreach ($value->opsi as $item)
                                                                                                @if ($item->type == 'checkbox')
                                                                                                    <div
                                                                                                        class="form-check ml-4">
                                                                                                        <input
                                                                                                            class="form-check-input"
                                                                                                            type="radio"
                                                                                                            name="jawaban_kt"
                                                                                                            value="{{ $item->id }}"
                                                                                                            @if ($pengawasan->status != 1 || auth()->user()->level_id != 'KT') disabled @endif>
                                                                                                        <label
                                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                                    </div>
                                                                                                @elseif($item->type == 'input')
                                                                                                    <p for="input">
                                                                                                        {{ $item->rincian }}
                                                                                                    </p>
                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->id }}"
                                                                                                        name="opsi{{ $loop->index }}">
                                                                                                    <input type="number"
                                                                                                        min="0"
                                                                                                        required
                                                                                                        class="form-control"
                                                                                                        name="input[]"
                                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                                        @if ($pengawasan->status != 1 || auth()->user()->level_id != 'KT') disabled @endif>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="catatan">Catatan</label>
                                                                                            <textarea class="form-control @error('catatan_kt') is-invalid  @enderror" rows="4" name="catatan_kt"
                                                                                                @if ($pengawasan->status != 1 || auth()->user()->level_id != 'KT') disabled @endif>{{ old('catatan_kt') }} </textarea>
                                                                                            @error('catatan_kt')
                                                                                                <div class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-start">
                                                                                            @if ($rekap->status == 4)
                                                                                                @if ($pengawasan->status == 1 && auth()->user()->level_id == 'KT')
                                                                                                    <button type="submit"
                                                                                                        class="submit-button btn btn-primary"
                                                                                                        name="submit_kt"
                                                                                                        value="kt"><i
                                                                                                            class="fas fa-save"></i>
                                                                                                        Simpan
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                        {{-- Pengendali Teknis --}}
                                                                        @if (auth()->user()->level_id == 'DL')
                                                                            @if ($deskEvaluation != null)
                                                                                @if ($pengawasan->tahap == 1 && $deskEvaluation->updated_dl == 0)
                                                                                    <div
                                                                                        class="col-lg-12 mb-3 d-flex justify-content-end">
                                                                                        <div
                                                                                            class="alert alert-info alert-dismissible">
                                                                                            <h5><i
                                                                                                    class="icon fas fa-info"></i>
                                                                                                Note</h5>
                                                                                            Jawaban dibawah ini adalah
                                                                                            Hasil
                                                                                            dari Ketua Tim, Harap Update
                                                                                            untuk
                                                                                            menandakan anda ikut
                                                                                            evaluasi
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if ($pengawasan->tahap == 2 && $deskEvaluation->updated_dl != 2)
                                                                                    <div
                                                                                        class="col-lg-12 mb-3 d-flex justify-content-end">
                                                                                        <div
                                                                                            class="alert alert-info alert-dismissible">
                                                                                            <h5><i
                                                                                                    class="icon fas fa-info"></i>
                                                                                                Note</h5>
                                                                                            Jawaban dibawah ini adalah
                                                                                            Hasil
                                                                                            dari Ketua Tim, Harap
                                                                                            Update
                                                                                            untuk
                                                                                            menandakan anda ikut
                                                                                            evaluasi
                                                                                        </div>
                                                                                    </div>
                                                                                @endif

                                                                                <div class="card-body">
                                                                                    <form
                                                                                        action="/tpi/evaluasi/{{ $deskEvaluation->id }}"
                                                                                        method="post">
                                                                                        @method('put')
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="anggota">Pengendali
                                                                                                Teknis
                                                                                            </label>
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->id }}"
                                                                                                name="rekapitulasi_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pilar->id }}"
                                                                                                name="pilar_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $penimbang }}"
                                                                                                name="penimbang">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pengawasan->id }}"
                                                                                                name="pengawasan">
                                                                                            <input type="hidden"
                                                                                                name="pertanyaan_id"
                                                                                                value="{{ $value->id }}">
                                                                                            <input type="hidden"
                                                                                                name="id_self"
                                                                                                value="{{ $selfAssessment->id }}">
                                                                                            @foreach ($value->opsi as $item)
                                                                                                @if ($item->type == 'checkbox')
                                                                                                    <div
                                                                                                        class="form-check ml-4">
                                                                                                        <input
                                                                                                            class="form-check-input"
                                                                                                            type="radio"
                                                                                                            name="jawaban_dl"
                                                                                                            value="{{ $item->id }}"
                                                                                                            @if ($pengawasan->status != 2 || auth()->user()->level_id != 'DL') disabled @endif
                                                                                                            @if ($deskEvaluation->jawaban_dl == $item->id) checked @endif>

                                                                                                        <label
                                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                                    </div>
                                                                                                @elseif($item->type == 'input')
                                                                                                    <p for="input">
                                                                                                        {{ $item->rincian }}
                                                                                                    </p>
                                                                                                    @php
                                                                                                        $desk = $deskEvaluation->InputField->where('opsi_id', $item->id)->first();
                                                                                                    @endphp
                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->id }}"
                                                                                                        name="opsi{{ $loop->index }}">
                                                                                                    <input type="number"
                                                                                                        min="0"
                                                                                                        required
                                                                                                        class="form-control"
                                                                                                        name="input[]"
                                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                                        @if ($pengawasan->status != 2 || auth()->user()->level_id != 'DL') disabled @endif
                                                                                                        value="{{ $desk->input_dl }}">
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="catatan">Catatan</label>
                                                                                            <textarea class="form-control @error('catatan_dl') is-invalid  @enderror" rows="4" name="catatan_dl"
                                                                                                @if ($pengawasan->status != 2 || auth()->user()->level_id != 'DL') disabled @endif>{{ old('catatan_dl', $deskEvaluation->catatan_dl) }}  </textarea>
                                                                                            @error('catatan_dl')
                                                                                                <div class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-start">
                                                                                            @if ($rekap->status == 4)
                                                                                                @if ($pengawasan->status == 2 && auth()->user()->level_id == 'DL')
                                                                                                    <button type="submit"
                                                                                                        class="submit-button btn btn-primary"
                                                                                                        name="submit_dl"
                                                                                                        value="dl"><i
                                                                                                            class="fas fa-save"></i>
                                                                                                        Simpan
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            @else
                                                                                {{-- Create --}}
                                                                                <div class="card-body">
                                                                                    <form action="/tpi/evaluasi"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="anggota">Pengendali
                                                                                                Teknis</label>
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->satker_id }}"
                                                                                                name="satker_id">
                                                                                            <input type="hidden"
                                                                                                name="pertanyaan_id"
                                                                                                value="{{ $value->id }}">
                                                                                            <input type="hidden"
                                                                                                value="{{ $rekap->id }}"
                                                                                                name="rekapitulasi_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pilar->id }}"
                                                                                                name="pilar_id">
                                                                                            <input type="hidden"
                                                                                                value="{{ $penimbang }}"
                                                                                                name="penimbang">
                                                                                            <input type="hidden"
                                                                                                value="{{ $pengawasan->id }}"
                                                                                                name="pengawasan">
                                                                                            <input type="hidden"
                                                                                                name="id_self"
                                                                                                value="{{ $selfAssessment->id }}">
                                                                                            @foreach ($value->opsi as $item)
                                                                                                @if ($item->type == 'checkbox')
                                                                                                    <div
                                                                                                        class="form-check ml-4">
                                                                                                        <input
                                                                                                            class="form-check-input"
                                                                                                            type="radio"
                                                                                                            name="jawaban_dl"
                                                                                                            value="{{ $item->id }}"
                                                                                                            @if ($pengawasan->status != 2 || auth()->user()->level_id != 'DL') disabled @endif>
                                                                                                        <label
                                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                                    </div>
                                                                                                @elseif($item->type == 'input')
                                                                                                    <p for="input">
                                                                                                        {{ $item->rincian }}
                                                                                                    </p>

                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->id }}"
                                                                                                        name="opsi{{ $loop->index }}">
                                                                                                    <input type="number"
                                                                                                        min="0"
                                                                                                        required
                                                                                                        class="form-control"
                                                                                                        name="input[]"
                                                                                                        @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                                        @if ($pengawasan->status != 2 || auth()->user()->level_id != 'DL') disabled @endif>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="catatan">Catatan</label>
                                                                                            <textarea class="form-control @error('catatan_dl') is-invalid  @enderror" rows="4" name="catatan_dl"
                                                                                                @if ($pengawasan->status != 2 || auth()->user()->level_id != 'DL') disabled @endif>{{ old('catatan_dl') }} </textarea>
                                                                                            @error('catatan_dl')
                                                                                                <div class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div
                                                                                            class="d-flex justify-content-start">
                                                                                            @if ($rekap->status == 4)
                                                                                                @if ($pengawasan->status == 2 && auth()->user()->level_id == 'DL')
                                                                                                    <button type="submit"
                                                                                                        class="submit-button btn btn-primary"
                                                                                                        name="submit_dl"
                                                                                                        value="dl"><i
                                                                                                            class="fas fa-save"></i>
                                                                                                        Simpan
                                                                                                    </button>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            @endif
                                                                        @endif

                                                                    </td>
                                                                @endif
                                                            @endif

                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12 mt-3">
                                <div class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                                    Satuan kerja Tidak Melakukan Self Assessment Pada Pilar {{ $value->subPilar }}.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <a href="/tpi/evaluasi/{{ $rekap->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
            Kembali</a>
    </div>


    {{-- Modal Info --}}
    @foreach ($subPilar as $value)
        @foreach ($value->pertanyaan as $value)
            <div class="modal fade" id="info{{ $value->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Informasi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Bukti Dukung:</p>
                            <ul>
                                @foreach ($value->dokumen as $item)
                                    <li>{{ $item->dokumen }}</li>
                                @endforeach
                            </ul>
                            {!! $value->info !!}

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endforeach
    @endforeach

    <script script src="{{ asset('template') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        var Toast = Swal.mixin({
            // toast: true,
            // position: 'top-end',
            // showConfirmButton: false,
            timer: 10000, // waktu dalam milidetik
            timerProgressBar: true,
        });
    </script>

    @if ($errors->any())
        <script>
            Toast.fire({
                icon: 'error',

                title: "{{ __('Error in form request!') }}",
                text: "{{ implode('', $errors->all()) }}",
                type: "error"
            });
        </script>
        <br>
    @endif
    <br>
    @if (Session::has('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}"
            })
        </script>
    @endif
@endsection
