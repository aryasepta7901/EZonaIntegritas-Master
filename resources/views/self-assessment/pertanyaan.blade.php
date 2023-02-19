@extends('layouts.backEnd.main')

@section('content')
    <div class="col-md-8 col-lg-12">
        <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
            @foreach ($subPilar as $value)
                @php
                    $pertanyaan = App\Models\Pertanyaan::where('subpilar_id', $value->id)->get(); //untuk mengambil data pertanyaan pertama
                    // Perhitungan Nilai setiap Pertanyaan
                    $jml_pertanyaan = $pertanyaan->count();
                    $penimbang = $value->bobot / $jml_pertanyaan;
                @endphp
                @foreach ($pertanyaan as $p)
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
                                        <tbody>
                                            @foreach ($value->pertanyaan as $value)
                                                <tr>
                                                    @php
                                                        $selfAssessment = App\Models\selfAssessment::where('pertanyaan_id', $value->id)
                                                            ->where('rekapitulasi_id', $rekap->id)
                                                            ->get();
                                                    @endphp
                                                    {{-- Update --}}
                                                    @if ($selfAssessment->count() != 0)
                                                        @foreach ($selfAssessment as $self)
                                                            <form method="POST"
                                                                action="/selfAssessment/{{ $self->id }}"
                                                                enctype="multipart/form-data">
                                                                @method('put')
                                                                @csrf
                                                                {{-- Data RekapPilar --}}
                                                                <input type="hidden" name="rekapitulasi_id"
                                                                    value="{{ $rekap->id }}">
                                                                <input type="hidden" name="pilar_id"
                                                                    value="{{ $pilar->id }}">
                                                                <input type="hidden" name="penimbang"
                                                                    value="{{ $penimbang }}">
                                                                {{-- Data RekapPilar --}}
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
                                                                            <textarea class="form-control @error('catatan') is-invalid  @enderror" rows="4" name="catatan">{{ old('catatan', $self->catatan) }} </textarea>
                                                                            @error('catatan')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        {{-- File Utama --}}
                                                                        <label for="catatan">Upload Dokumen</label>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>No</th>
                                                                                    <th>Nama Dokumen</th>
                                                                                    <th>File</th>
                                                                                    <th>Upload</th>
                                                                                    @can('pic')
                                                                                        @if ($rekap->status == 0 || $rekap->status == 2)
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
                                                                                        <td>
                                                                                            <div class="custom-file">
                                                                                                <input type="file"
                                                                                                    class="custom-file-input"
                                                                                                    id="customFile"
                                                                                                    name="dokumen[]">
                                                                                                <label
                                                                                                    class="custom-file-label"
                                                                                                    for="customFile">Update
                                                                                                    File</label>
                                                                                            </div>
                                                                                        </td>
                                                                                        {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                                        @can('pic')
                                                                                            @if ($rekap->status == 0 || $rekap->status == 2)
                                                                                                @if ($file->count() != 0)
                                                                                                    @foreach ($file as $f)
                                                                                                        <td class="text-center">
                                                                                                            <button
                                                                                                                type="button"
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
                                                                                multiple>
                                                                            <label class="custom-file-label"
                                                                                for="formFileMultiple">
                                                                                Dokumen Tambahan</label>

                                                                        </div>
                                                                        <table
                                                                            class="table table-bordered table-striped mt-3">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>No</th>
                                                                                    <th>Nama Dokumen</th>
                                                                                    <th>File</th>
                                                                                    <th>Upload</th>
                                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                                    @can('pic')
                                                                                        @if ($rekap->status == 0 || $rekap->status == 2)
                                                                                            <th>Delete</th>
                                                                                        @endif
                                                                                    @endcan

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($value->file->where('selfassessment_id', $self->id) as $item)
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                        <td style="min-width: 200px">
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
                                                                                        <td>
                                                                                            <div class="custom-file">
                                                                                                <input type="file"
                                                                                                    class="custom-file-input"
                                                                                                    id="customFile"
                                                                                                    name="fileUpdate[]">
                                                                                                <label
                                                                                                    class="custom-file-label"
                                                                                                    for="customFile">Update
                                                                                                    File</label>

                                                                                            </div>
                                                                                        </td>
                                                                                        {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                                        @can('pic')
                                                                                            @if ($rekap->status == 0 || $rekap->status == 2)
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
                                                                        {{-- File Tambahan --}}
                                                                    </div>
                                                                    <hr>
                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                    @can('pic')
                                                                        @if ($rekap->status == 0 || $rekap->status == 2)
                                                                            <div class="d-flex justify-content-end mr-3">

                                                                                <button type="submit"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fas fa-save"></i>
                                                                                    Update
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    @endcan



                                                                </td>
                                                                <td style="min-width: 150px;">
                                                                    <p>Bukti Dukung:</p>
                                                                    <ul>
                                                                        @foreach ($value->dokumen as $item)
                                                                            <li>{{ $item->dokumen }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                    {!! $value->info !!}
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
                                                                                <b>{{ $item->name }}
                                                                                    ?</b>
                                                                            </div>
                                                                            <form
                                                                                action="/selfAssessment/{{ $item->id }}"
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
                                                                    <div class="modal fade"
                                                                        id="hapus{{ $f->id }}">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title">
                                                                                        Hapus</h4>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
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
                                                        @endforeach
                                                    @else
                                                        {{-- Create --}}
                                                        <form method="POST" action="/selfAssessment"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            {{-- Data RekapPilar --}}
                                                            <input type="hidden" name="rekapitulasi_id"
                                                                value="{{ $rekap->id }}">
                                                            <input type="hidden" name="pilar_id"
                                                                value="{{ $pilar->id }}">
                                                            <input type="hidden" name="penimbang"
                                                                value="{{ $penimbang }}">
                                                            {{-- Data RekapPilar --}}
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
                                                                        <textarea class="form-control @error('catatan') is-invalid  @enderror" rows="4" name="catatan">{{ old('catatan') }} </textarea>
                                                                        @error('catatan')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <label for="catatan">Upload Dokumen</label>
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

                                                                                <td>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                            class="custom-file-input"
                                                                                            id="customFile"
                                                                                            name="dokumen[]">
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
                                                                        multiple>
                                                                    <label class="custom-file-label"
                                                                        for="formFileMultiple">
                                                                        Dokumen Tambahan</label>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex justify-content-end mr-3">
                                                                    {{-- Jika status rekapitulasi masih dalam tahap penilaian mandiri maka: --}}
                                                                    @can('pic')
                                                                        @if ($rekap->status == 0 || $rekap->status == 2)
                                                                            <button type="submit" class="btn btn-primary"><i
                                                                                    class="fas fa-save"></i>
                                                                                Simpan
                                                                            </button>
                                                                        @endif
                                                                    @endcan

                                                                </div>
                                                            </td>
                                                            <td style="min-width: 150px;">
                                                                <p>Bukti Dukung:</p>
                                                                <ul>
                                                                    @foreach ($value->dokumen as $item)
                                                                        <li>{{ $item->dokumen }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                {!! $value->info !!}
                                                            </td>
                                                        </form>
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

        {{-- Jika yang akses Tim Evaluator Provinsi --}}
        @can('EvalProv')
            <a href="/prov/evaluasi/{{ $rekap->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
                Kembali</a>
        @endcan
        {{-- Jika yang akses  PIC --}}

        @can('pic')
            <a href="/lke/{{ $rekap->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
                Kembali</a>
        @endcan


    </div>

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
