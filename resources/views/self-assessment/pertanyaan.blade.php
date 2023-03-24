@extends('layouts.backEnd.main')

@section('content')
    <div class="col-md-8 col-lg-12">
        @foreach ($subPilar as $value)
            @php
                // Perhitungan Nilai setiap Pertanyaan
                $jml_pertanyaan = $value->pertanyaan->count();
                $penimbang = $value->bobot / $jml_pertanyaan;
                $total_sa = 0;
                $total_dl = 0;
            @endphp
            @foreach ($value->pertanyaan as $p)
                @php
                    // Self Assessment
                    $nilai = $p->SelfAssessment->where('rekapitulasi_id', $rekap->id)->sum('nilai');
                    $total_sa += $nilai * $penimbang;
                @endphp
                @foreach ($p->SelfAssessment->where('rekapitulasi_id', $rekap->id) as $s)
                    @php
                        // Desk Evaluation
                        $nilai_dl = $s->DeskEvaluation->sum('nilai_dl');
                        $total_dl += $nilai_dl * $penimbang;
                    @endphp
                @endforeach
            @endforeach
            <div class="myaccordion w-100" id="accordion" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header p-0" id="heading{{ $loop->iteration }}">
                        <h2 class="mb-0">
                            <button href="#collapse{{ $loop->iteration }}"
                                class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link button"
                                data-parent="#accordion" data-toggle="collapse" aria-expanded=""
                                aria-controls="collapse{{ $loop->iteration }}">
                                <p class="mb-0">{{ $value->subPilar }} ({{ $value->bobot }})</p>
                                <div class="d-flex justify-content-between ">
                                    <p class="info-box-number m-4">Nilai : {{ round($total_sa, 2) }}</p>
                                    <i class="fa my-4 " aria-hidden="true"></i>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div class="collapse" id="collapse{{ $loop->iteration }}" role="tabpanel"
                        aria-labelledby="heading{{ $loop->iteration }}">
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
                                                    {{-- Self Assessment --}}
                                                    <div class="d-flex justify-content-between">
                                                        Self-Assessment
                                                        <button class="badge badge-info btn-sm">Nilai :
                                                            {{ round($total_sa, 2) }}</button>
                                                    </div>
                                                </th>
                                                {{-- Desk Evaluation --}}
                                                @if ($rekap->status == 5 || $rekap->status == 6 || $rekap->status == 7)
                                                    <th>
                                                        <div class="d-flex justify-content-between">
                                                            Desk-Evaluation
                                                            <button class="badge badge-info btn-sm">Nilai :
                                                                {{ round($total_dl, 2) }}</button>
                                                        </div>

                                                    </th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($value->pertanyaan as $value)
                                                <tr class="rowAccordion">
                                                    @php
                                                        $selfAssessment = $value->SelfAssessment->where('rekapitulasi_id', $rekap->id)->first();
                                                    @endphp
                                                    {{-- Self Assessment --}}
                                                    @if ($selfAssessment != null)
                                                        {{-- Update --}}
                                                        <form method="POST"
                                                            action="/selfAssessment/{{ $selfAssessment->id }}"
                                                            enctype="multipart/form-data">
                                                            @method('put')
                                                            @csrf
                                                            {{-- Data RekapPengungkit --}}
                                                            <input type="hidden" name="rekapitulasi_id"
                                                                value="{{ $rekap->id }}">
                                                            <input type="hidden" name="pilar_id"
                                                                value="{{ $pilar->id }}">
                                                            <input type="hidden" name="penimbang"
                                                                value="{{ $penimbang }}">
                                                            {{-- Data RekapPengungkit --}}
                                                            <td style="min-width: 650px;">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="pertanyaan">{{ $value->pertanyaan }}</label>
                                                                        <input type="hidden" name="pertanyaan_id"
                                                                            value="{{ $value->id }}">
                                                                        @foreach ($value->opsi as $item)
                                                                            @if ($item->type == 'checkbox')
                                                                                <div class="form-check ml-4">
                                                                                    <input
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
                                                                                <p for="input">{{ $item->rincian }}
                                                                                </p>

                                                                                <input type="hidden"
                                                                                    value="{{ $item->id }}"
                                                                                    name="opsi{{ $loop->index }}">
                                                                                <input type="number" min="0"
                                                                                    required class="form-control"
                                                                                    name="input[]"
                                                                                    @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif
                                                                                    value="{{ $self->input_sa }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="catatan">Catatan</label>
                                                                        <textarea class="form-control @error('catatan') is-invalid  @enderror" rows="4" name="catatan">{{ old('catatan', $selfAssessment->catatan) }} </textarea>
                                                                        @error('catatan')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    {{-- File Utama --}}
                                                                    <label for="catatan">Upload Dokumen</label>
                                                                    <small class="text-danger">Dokumen maksimal 2MB,
                                                                        dengan
                                                                        extensi *PDF</small>
                                                                    <table class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr class="text-center">
                                                                                <th>No</th>
                                                                                <th>Nama Dokumen</th>
                                                                                <th>File</th>
                                                                                <th>Upload</th>
                                                                                @can('pic')
                                                                                    @if ($rekap->status == 0 || $rekap->status == 2 || $rekap->status == 5)
                                                                                        <th>Delete</th>
                                                                                    @endif
                                                                                @endcan

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
                                                                                    <td style="min-width: 250px">
                                                                                        <div class="custom-file">
                                                                                            <input type="file"
                                                                                                class="custom-file-input"
                                                                                                id="customFile"
                                                                                                name="dokumen[]"
                                                                                                accept="application/pdf">
                                                                                            <label
                                                                                                class="custom-file-label"
                                                                                                for="customFile">Update
                                                                                                File</label>
                                                                                        </div>
                                                                                    </td>
                                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri atau revisi dari provinsi dan TPI: --}}
                                                                                    @can('pic')
                                                                                        @if ($rekap->status == 0 || $rekap->status == 2 || $rekap->status == 5)
                                                                                            @if ($file->count() != 0)
                                                                                                @foreach ($file as $f)
                                                                                                    <td class="text-center">
                                                                                                        <button type="button"
                                                                                                            class="btn btn-sm btn-danger"
                                                                                                            data-toggle="modal"
                                                                                                            data-target="#hapus{{ $f->id }}"><i
                                                                                                                class="fa fa-trash"></i></button>
                                                                                                    </td>
                                                                                                @endforeach
                                                                                            @else
                                                                                                <td></td>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endcan


                                                                                </tr>
                                                                            @endforeach

                                                                        </tbody>
                                                                    </table>
                                                                    {{-- File Utama --}}
                                                                    {{-- File Tambahan --}}
                                                                    <label for="catatan">Upload Dokumen
                                                                        Tambahan</label>
                                                                    <div class="custom-file">

                                                                        <input type="file" class="custom-file-input"
                                                                            id="formFileMultiple" name="fileCreate[]"
                                                                            accept="application/pdf" multiple>
                                                                        <label class="custom-file-label"
                                                                            for="formFileMultiple">
                                                                            Dokumen Tambahan</label>

                                                                    </div>
                                                                    @php
                                                                        $file = $value->file->where('selfassessment_id', $selfAssessment->id);
                                                                    @endphp
                                                                    @if ($file->count() != 0)
                                                                        {{-- Jika ada file tambahan --}}
                                                                        <table
                                                                            class="table table-bordered table-striped mt-3">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>No</th>
                                                                                    <th>Nama Dokumen</th>
                                                                                    <th>File</th>
                                                                                    <th>Upload</th>
                                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri atau revisi dari provinsi dan TPI: --}}
                                                                                    @can('pic')
                                                                                        @if ($rekap->status == 0 || $rekap->status == 2 || $rekap->status == 5)
                                                                                            <th>Delete</th>
                                                                                        @endif
                                                                                    @endcan

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($file as $item)
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>
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
                                                                                        <td>
                                                                                            <div class="custom-file">
                                                                                                <input type="file"
                                                                                                    class="custom-file-input"
                                                                                                    id="customFile"
                                                                                                    name="fileUpdate[]"
                                                                                                    accept="application/pdf">
                                                                                                <label
                                                                                                    class="custom-file-label"
                                                                                                    for="customFile">Update
                                                                                                    File</label>

                                                                                            </div>
                                                                                        </td>
                                                                                        {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri atau revisi dari provinsi dan TPI: --}}
                                                                                        @can('pic')
                                                                                            @if ($rekap->status == 0 || $rekap->status == 2 || $rekap->status == 5)
                                                                                                <td class="text-center">
                                                                                                    <button type="button"
                                                                                                        class="btn btn-sm btn-danger"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#hapus{{ $item->id }}"><i
                                                                                                            class="fa fa-trash"></i></button>
                                                                                                </td>
                                                                                            @endif
                                                                                        @endcan


                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    @endif

                                                                    {{-- File Tambahan --}}
                                                                </div>

                                                                <hr>
                                                                {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri atau revisi dari provinsi dan TPI: --}}
                                                                @can('pic')
                                                                    @if ($rekap->status == 0 || $rekap->status == 2 || $rekap->status == 5)
                                                                        <div class="d-flex justify-content-end mr-3">

                                                                            <button type="submit"
                                                                                class="submit-button btn btn-primary"><i
                                                                                    class="fas fa-save"></i>
                                                                                Update
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                @endcan
                                                            </td>

                                                        </form>

                                                        {{-- Modal Delete File Utama --}}
                                                        @foreach ($value->file as $item)
                                                            <div class="modal fade" id="hapus{{ $item->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">
                                                                                Hapus</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="text-danger">
                                                                                Apakah Anda
                                                                                Yakin untuk
                                                                                Menghapus
                                                                                Dokumen</p>
                                                                            <b>{{ $item->name }}
                                                                                ?</b>
                                                                        </div>
                                                                        <form action="/selfAssessment/{{ $item->id }}"
                                                                            method="POST" class="d-inline">
                                                                            @method('delete')
                                                                            @csrf
                                                                            <div
                                                                                class="modal-footer justify-content-between">
                                                                                <button type="button"
                                                                                    class="btn btn-default"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Delete</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                        @endforeach
                                                        {{-- Modal Delete File Tambahan --}}
                                                        @foreach ($value->dokumen as $item)
                                                            @foreach ($item->file as $f)
                                                                <div class="modal fade" id="hapus{{ $f->id }}">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">
                                                                                    Hapus</h4>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p class="text-danger">
                                                                                    Apakah Anda
                                                                                    Yakin untuk
                                                                                    Menghapus
                                                                                    Dokumen</p>
                                                                                <b>{{ $f->name }}
                                                                                    ?</b>
                                                                            </div>
                                                                            <form
                                                                                action="/selfAssessment/{{ $f->id }}"
                                                                                method="POST" class="d-inline">
                                                                                @method('delete')
                                                                                @csrf
                                                                                <div
                                                                                    class="modal-footer justify-content-between">
                                                                                    <button type="button"
                                                                                        class="btn btn-default"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Delete</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- /.modal-content -->
                                                                    </div>
                                                                    <!-- /.modal-dialog -->
                                                                </div>
                                                            @endforeach
                                                        @endforeach
                                                    @else
                                                        {{-- Create --}}
                                                        <form method="POST" action="/selfAssessment"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            {{-- Data RekapPengungkit --}}
                                                            <input type="hidden" name="rekapitulasi_id"
                                                                value="{{ $rekap->id }}">
                                                            <input type="hidden" name="pilar_id"
                                                                value="{{ $pilar->id }}">
                                                            <input type="hidden" name="penimbang"
                                                                value="{{ $penimbang }}">
                                                            {{-- Data RekapPengungkit --}}
                                                            <td style="min-width: 650px;">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label class="row"
                                                                            for="pertanyaan">{{ $value->pertanyaan }}</label>
                                                                        <input type="hidden" name="pertanyaan_id"
                                                                            value="{{ $value->id }}">
                                                                        @foreach ($value->opsi as $item)
                                                                            @if ($item->type == 'checkbox')
                                                                                <div class="form-check ml-4">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="opsi_id"
                                                                                        value="{{ $item->id }}">
                                                                                    <label
                                                                                        class="form-check-label">{{ $item->rincian }}</label>
                                                                                </div>
                                                                            @elseif($item->type == 'input')
                                                                                <p for="input">{{ $item->rincian }}
                                                                                </p>
                                                                                <input type="hidden"
                                                                                    value="{{ $item->id }}"
                                                                                    name="opsi{{ $loop->index }}">
                                                                                <input type="number" min="0"
                                                                                    required class="form-control"
                                                                                    name="input[]"
                                                                                    @if ($item->id == 'PRE3A1' || $item->id == 'PRE3B1' || $item->id == 'PRE2A1') readonly @endif>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="catatan">Catatan</label>
                                                                        <textarea class="form-control @error('catatan') is-invalid  @enderror" rows="4" name="catatan">{{ old('catatan') }} </textarea>
                                                                        @error('catatan')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <label for="catatan">Upload Dokumen</label>
                                                                <small class="text-danger">Dokumen maksimal 2MB, dengan
                                                                    extensi *PDF</small>
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr class="text-center">
                                                                            <th>No</th>
                                                                            <th>Nama Dokumen</th>
                                                                            <th>Upload</th>
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

                                                                                <td style="min-width: 250px">
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                            class="custom-file-input"
                                                                                            id="customFile"
                                                                                            name="dokumen[]"
                                                                                            accept="application/pdf">
                                                                                        <label class="custom-file-label"
                                                                                            for="customFile">Choose
                                                                                            file</label>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>

                                                                </table>
                                                                <label for="catatan">Upload Dokumen
                                                                    Tambahan</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="formFileMultiple" name="fileCreate[]"
                                                                        accept="application/pdf" multiple>
                                                                    <label class="custom-file-label"
                                                                        for="formFileMultiple">
                                                                        Dokumen Tambahan</label>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex justify-content-end mr-3">
                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri / evaluasi dari Provinsi dan TPI maka: --}}
                                                                    @can('pic')
                                                                        @if ($rekap->status == 0 || $rekap->status == 2 || $rekap->status == 5)
                                                                            <button type="submit"
                                                                                class="submit-button btn btn-primary"><i
                                                                                    class="fas fa-save"></i>
                                                                                Simpan
                                                                            </button>
                                                                        @endif
                                                                    @endcan
                                                                </div>
                                                            </td>
                                                        </form>
                                                    @endif
                                                    {{-- Desk Evaluation --}}
                                                    @php
                                                        $id = date('Y') . $rekap->satker_id . $value->id;
                                                        $deskEvaluation = $DeskEvaluation->where('id', $id)->first();
                                                    @endphp
                                                    @if ($rekap->status == 5 || $rekap->status == 6 || $rekap->status == 7)
                                                        <td style="min-width: 380px;">
                                                            {{-- Pengendali Teknis --}}
                                                            @if ($deskEvaluation != null)
                                                                <div class="card-body"
                                                                    @if ($deskEvaluation->nilai_dl === 0) style="background-color: red" @endif>
                                                                    <form action="/tpi/evaluasi/{{ $deskEvaluation->id }}"
                                                                        method="post">
                                                                        @method('put')
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="anggota">Pengendali
                                                                                Teknis
                                                                            </label>
                                                                            @foreach ($value->opsi as $item)
                                                                                @if ($item->type == 'checkbox')
                                                                                    <div class="form-check ml-4">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="jawaban_dl"
                                                                                            value="{{ $item->id }}"
                                                                                            @if ($deskEvaluation->jawaban_dl == $item->id) checked @endif>

                                                                                        <label
                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                    </div>
                                                                                @elseif($item->type == 'input')
                                                                                    <p for="input">
                                                                                        {{ $item->rincian }}
                                                                                    </p>
                                                                                    <input type="number" min="0"
                                                                                        class="form-control"
                                                                                        name="jawaban_dl">
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="catatan">Catatan</label>
                                                                            <textarea class="form-control @error('catatan_dl') is-invalid  @enderror" rows="4" name="catatan_dl">{{ old('catatan_dl', $deskEvaluation->catatan_dl) }}  </textarea>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="col-lg-12">
                                                                    <div class="alert alert-info alert-dismissible">
                                                                        <h5><i class="icon fas fa-info"></i> Informasi!
                                                                        </h5>
                                                                        Tim Penilai Internal Belum Melakukan Penilaian pada
                                                                        pertanyaan ini!
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <hr>
                                                            <p>Bukti Dukung:</p>
                                                            <ul>
                                                                @foreach ($value->dokumen as $item)
                                                                    <li>{{ $item->dokumen }}</li>
                                                                @endforeach
                                                            </ul>
                                                            Link :
                                                            <a target="__self"
                                                                href="{{ $value->info }}">{{ $value->info }}</a>
                                                        </td>
                                                    @else
                                                        <td style="min-width: 150px;">
                                                            <p>Bukti Dukung:</p>
                                                            <ul>
                                                                @foreach ($value->dokumen as $item)
                                                                    <li>{{ $item->dokumen }}</li>
                                                                @endforeach
                                                            </ul>
                                                            Link :
                                                            <a target="__self"
                                                                href="{{ $value->info }}">{{ $value->info }}</a>

                                                        </td>
                                                    @endif


                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Jika yang akses Tim Evaluator Provinsi --}}
        @can('EvalProv')
            <a href="/prov/evaluasi/{{ $rekap->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
                Kembali</a>
        @endcan
        {{-- Jika yang akses  PIC --}}

        @can('pic')
            <a href="/satker/lke/{{ $rekap->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
                Kembali</a>
        @endcan


    </div>

    <script script src="{{ asset('template') }}/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
            customClass: {
                popup: 'animate__animated animate__bounceIn', // Tambahkan animasi bounceIn
            }
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
