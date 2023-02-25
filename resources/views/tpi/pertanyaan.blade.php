@extends('layouts.backEnd.main')

@section('content')
    <div class="col-md-8 col-lg-12">
        <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
            @foreach ($subPilar as $value)
                @php
                    // Perhitungan Nilai setiap Pertanyaan
                    $jml_pertanyaan = $value->pertanyaan->count();
                    $penimbang = $value->bobot / $jml_pertanyaan;
                @endphp
                @foreach ($value->pertanyaan as $p)
                    @php
                        $nilai = App\Models\selfAssessment::where('pertanyaan_id', 'LIKE', '%' . $p->subpilar_id . '%')
                            ->where('rekapitulasi_id', $rekap->id)
                            ->sum('nilai'); //mengambil nilai
                        $total = round($nilai * $penimbang, 2);
                    @endphp
                @endforeach
                <div class="card">
                    <div class="card-header p-0" id="heading{{ $loop->iteration }}">
                        <h2 class="mb-0">
                            <button href="#collapse{{ $loop->iteration }}"
                                class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link button"
                                data-parent="#accordion" data-toggle="collapse" aria-expanded="true"
                                aria-controls="collapse{{ $loop->iteration }}">
                                <p class="mb-0">{{ $value->subPilar }} ({{ $value->bobot }})</p>
                                <div class="d-flex justify-content-between ">
                                    <p class="info-box-number m-4">Nilai : {{ $total }}</p>
                                    <i class="fa my-4 " aria-hidden="true"></i>

                                </div>
                            </button>
                        </h2>
                    </div>
                    <div class="collapse show" id="collapse{{ $loop->iteration }}" role="tabpanel"
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
                                                <th>Self-Assessment</th>
                                                @if ($rekap->status == 4)
                                                    <th>Desk-Evaluation</th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($value->pertanyaan as $value)
                                                <tr>
                                                    @php
                                                        $selfAssessment = App\Models\selfAssessment::where('pertanyaan_id', $value->id)
                                                            ->where('rekapitulasi_id', $rekap->id)
                                                            ->get();
                                                    @endphp
                                                    {{-- Self Assessment --}}
                                                    {{-- Sudah Diisi --}}
                                                    @if ($selfAssessment->count() != 0)
                                                        @foreach ($selfAssessment as $self)
                                                            {{-- Data RekapPilar --}}
                                                            <form action="">
                                                                <td style="min-width:500px;">
                                                                    <div class="card-body">
                                                                        <div class="form-group">
                                                                            <div class="d-flex justify-content-around">
                                                                                <label
                                                                                    for="pertanyaan">{{ $value->pertanyaan }}</label>

                                                                                <button type="button" data-toggle="modal"
                                                                                    data-target="#info{{ $value->id }}"
                                                                                    class="btn btn-sm btn-info"> <i
                                                                                        class="fas fa-info"></i></button>
                                                                            </div>

                                                                            @foreach ($value->opsi as $item)
                                                                                @if ($item->type == 'checkbox')
                                                                                    <div class="form-check ml-4">
                                                                                        <input
                                                                                            @if ($self->opsi_id == $item->id) checked @endif
                                                                                            class="form-check-input"
                                                                                            type="radio" name="opsi_id"
                                                                                            value="{{ $item->id }}">
                                                                                        <label
                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                    </div>
                                                                                @elseif($item->type == 'input')
                                                                                    <p for="input">{{ $item->rincian }}
                                                                                    </p>
                                                                                    <input type="number" min="0"
                                                                                        class="form-control" name="opsi_id">
                                                                                @endif
                                                                            @endforeach
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="catatan">Catatan</label>
                                                                            <textarea class="form-control" rows="4" name="catatan">{{ old('catatan', $self->catatan) }} </textarea>

                                                                        </div>
                                                                        {{-- File Utama --}}
                                                                        <label for="catatan">Upload Dokumen</label>
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
                                                                                        <td style="min-width: 200px"
                                                                                            class="text-center">
                                                                                            {{ $item->dokumen }}
                                                                                            <input type="hidden"
                                                                                                name="id{{ $loop->index }}"
                                                                                                value="{{ $item->id }}">
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            @php
                                                                                                $file = $item->file->where('selfassessment_id', $self->id);
                                                                                            @endphp
                                                                                            @if ($file->count() != 0)
                                                                                                @foreach ($file as $f)
                                                                                                    <a target="__self"
                                                                                                        href="{{ asset('storage/' . $f->file) }}"><i
                                                                                                            class="fas fa-file"></i></a>
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
                                                                        <label for="catatan">Upload Dokumen
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
                                                                                @foreach ($value->file->where('selfassessment_id', $self->id) as $item)
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                        <td class="text-center"
                                                                                            style="min-width: 200px">
                                                                                            {{ $item->name }}
                                                                                            <input type="hidden"
                                                                                                name="upload_id{{ $loop->index }}"
                                                                                                value="{{ $item->id }}">
                                                                                        </td>

                                                                                        <td class="text-center">
                                                                                            <a target="__self"
                                                                                                href="{{ asset('storage/' . $item->file) }}"><i
                                                                                                    class="fas fa-file"></i></a>
                                                                                        </td>

                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                        {{-- File Tambahan --}}
                                                                    </div>
                                                                    <hr>
                                                                </td>
                                                            </form>
                                                        @endforeach
                                                        {{-- Belum diisi --}}
                                                    @else
                                                        {{-- Data RekapPilar --}}
                                                        <td style="min-width:500px;">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <div class="d-flex justify-content-around">
                                                                        <label
                                                                            for="pertanyaan">{{ $value->pertanyaan }}</label>

                                                                        <button type="button" data-toggle="modal"
                                                                            data-target="#info{{ $value->id }}"
                                                                            class="btn btn-sm btn-info"> <i
                                                                                class="fas fa-info"></i></button>
                                                                    </div>


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
                                                                            <input type="number" min="0"
                                                                                class="form-control" name="opsi_id">
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="catatan">Catatan</label>
                                                                    <textarea class="form-control  " rows="4" name="catatan">{{ old('catatan') }} </textarea>
                                                                </div>
                                                            </div>

                                                            <label for="catatan">Upload Dokumen</label>
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
                                                                            <td class="text-center"> <small>No Data</small>
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>

                                                            </table>
                                                            <hr>
                                                        </td>
                                                    @endif

                                                    {{-- Desk Evaluation TPI --}}
                                                    @php
                                                        $id = date('Y') . $rekap->satker_id . $value->id;
                                                        $deskEvaluation = App\Models\deskEvaluation::where('id', $id)->get();
                                                    @endphp

                                                    @if ($rekap->status == 4)
                                                        <td style="min-width:500px;">
                                                            {{-- Anggota Tim --}}
                                                            {{-- Update --}}
                                                            @if ($deskEvaluation->count() != 0)
                                                                @foreach ($deskEvaluation as $desk)
                                                                    <div class="card-body">
                                                                        <form action="/tpi/evaluasi/{{ $desk->id }}"
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

                                                                                @foreach ($value->opsi as $item)
                                                                                    @if ($item->type == 'checkbox')
                                                                                        <div class="form-check ml-4">
                                                                                            <input class="form-check-input"
                                                                                                type="radio"
                                                                                                name="jawaban_at"
                                                                                                value="{{ $item->id }}"
                                                                                                @if ($pengawasan->status != 0) disabled @endif
                                                                                                @if ($desk->jawaban_at == $item->id) checked @endif>

                                                                                            <label
                                                                                                class="form-check-label">{{ $item->rincian }}</label>
                                                                                        </div>
                                                                                    @elseif($item->type == 'input')
                                                                                        <p for="input">
                                                                                            {{ $item->rincian }}
                                                                                        </p>
                                                                                        <input type="number"
                                                                                            min="0"
                                                                                            class="form-control"
                                                                                            name="jawaban_at"
                                                                                            @if ($pengawasan->status != 0) disabled @endif>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="catatan">Catatan</label>
                                                                                <textarea class="form-control @error('catatan_at') is-invalid  @enderror" rows="4" name="catatan_at">{{ old('catatan_at', $desk->catatan_at) }} </textarea>
                                                                                @error('catatan_at')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="d-flex justify-content-start">
                                                                                {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                                @if ($rekap->status == 4 && $pengawasan->status == 0)
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary"
                                                                                        name="submit_at" value="at"><i
                                                                                            class="fas fa-save"></i>
                                                                                        Update
                                                                                    </button>
                                                                                @endif
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                {{-- Create --}}
                                                                <div class="card-body">
                                                                    <form action="/tpi/evaluasi" method="post">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="anggota">Anggota Tim</label>
                                                                            <input type="hidden"
                                                                                value="{{ $rekap->satker_id }}"
                                                                                name="satker_id">
                                                                            <input type="hidden" name="pertanyaan_id"
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

                                                                            @foreach ($value->opsi as $item)
                                                                                @if ($item->type == 'checkbox')
                                                                                    <div class="form-check ml-4">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="jawaban_at"
                                                                                            value="{{ $item->id }}"
                                                                                            @if ($pengawasan->status != 0) disabled @endif>

                                                                                        <label
                                                                                            class="form-check-label">{{ $item->rincian }}</label>
                                                                                    </div>
                                                                                @elseif($item->type == 'input')
                                                                                    <p for="input">
                                                                                        {{ $item->rincian }}
                                                                                    </p>
                                                                                    <input type="number" min="0"
                                                                                        class="form-control"
                                                                                        name="jawaban_at"
                                                                                        @if ($pengawasan->status != 0) disabled @endif>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="catatan">Catatan</label>
                                                                            <textarea class="form-control @error('catatan_at') is-invalid  @enderror" rows="4" name="catatan_at">{{ old('catatan_at') }} </textarea>
                                                                            @error('catatan_at')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="d-flex justify-content-start">
                                                                            {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                            @if ($rekap->status == 4 && $pengawasan->status == 0)
                                                                                <button type="submit"
                                                                                    class="btn btn-primary"
                                                                                    name="submit_at" value="at"><i
                                                                                        class="fas fa-save"></i>
                                                                                    Simpan
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                            <hr>
                                                            {{-- Ketua Tim --}}
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="anggota">Ketua Tim</label>
                                                                    @foreach ($value->opsi as $item)
                                                                        @if ($item->type == 'checkbox')
                                                                            <div class="form-check ml-4">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="opsi_id"
                                                                                    value="{{ $item->id }}"
                                                                                    @if ($pengawasan->status != 1) disabled @endif>
                                                                                <label
                                                                                    class="form-check-label">{{ $item->rincian }}</label>
                                                                            </div>
                                                                        @elseif($item->type == 'input')
                                                                            <p for="input">{{ $item->rincian }}
                                                                            </p>
                                                                            <input type="number" min="0"
                                                                                class="form-control" name="opsi_id"
                                                                                @if ($pengawasan->status != 1) disabled @endif>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="catatan">Catatan</label>
                                                                    <textarea class="form-control  " rows="4" name="catatan" @if ($pengawasan->status != 1) disabled @endif>
                                                                    {{ old('catatan') }} </textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-start">
                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                    @if ($rekap->status == 4 && $pengawasan->status == 1)
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            {{-- Pengendali Teknis --}}
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="anggota">Pengendali Teknis</label>
                                                                    @foreach ($value->opsi as $item)
                                                                        @if ($item->type == 'checkbox')
                                                                            <div class="form-check ml-4">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="opsi_id"
                                                                                    value="{{ $item->id }}"
                                                                                    @if ($pengawasan->status != 2) disabled @endif>
                                                                                <label
                                                                                    class="form-check-label">{{ $item->rincian }}</label>
                                                                            </div>
                                                                        @elseif($item->type == 'input')
                                                                            <p for="input">{{ $item->rincian }}
                                                                            </p>
                                                                            <input type="number" min="0"
                                                                                class="form-control" name="opsi_id"
                                                                                @if ($pengawasan->status != 2) disabled @endif>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="catatan">Catatan</label>
                                                                    <textarea class="form-control  " rows="4" name="catatan" @if ($pengawasan->status != 2) disabled @endif>
                                                                    {{ old('catatan') }} </textarea>
                                                                </div>
                                                                <div class="d-flex justify-content-start">
                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                    @if ($rekap->status == 4 && $pengawasan->status == 2)
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
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
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 10000
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
