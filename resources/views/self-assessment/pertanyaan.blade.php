@extends('layouts.backEnd.main')

@section('content')
    <div class="col-md-8 col-lg-12">

        <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
            @php
                $subPilar = App\Models\SubPilar::where('pilar_id', $pilar->id)->get(); //untuk mengambil data subPilar
            @endphp
            @foreach ($subPilar as $value)
                @php
                    $pertanyaan = App\Models\Pertanyaan::where('subpilar_id', $value->id)->get(); //untuk mengambil data pertanyaan pertama
                    // Perhitungan Nilai setiap Pertanyaan
                    $jml_pertanyaan = $pertanyaan->count();
                    $penimbang = $value->bobot / $jml_pertanyaan;
                    
                @endphp
                @foreach ($pertanyaan as $p)
                    @php
                        $nilai = App\Models\selfAssessment::where('pertanyaan_id', 'LIKE', '%' . $p->subpilar_id . '%')->sum('nilai'); //mengambil nilai
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
                                            @foreach ($pertanyaan as $value)
                                                <tr>
                                                    @php
                                                        $opsi = App\Models\Opsi::where('pertanyaan_id', $value->id)->get(); //untuk mengambil data Opsi
                                                        $dokumen = App\Models\dokumenLKE::where('pertanyaan_id', $value->id)->get(); //untuk mengambil data Opsi
                                                        $selfAssessment = App\Models\selfAssessment::where('pertanyaan_id', $value->id)->get();
                                                    @endphp

                                                    {{-- Update --}}
                                                    @if ($selfAssessment->count() != 0)
                                                        @foreach ($selfAssessment as $self)
                                                            <form method="POST" action="/selfAssessment"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <td style="min-width: 550px;">
                                                                    <div class="card-body">

                                                                        <div class="form-group">
                                                                            <label
                                                                                for="pertanyaan">{{ $value->pertanyaan }}</label>
                                                                            <input type="hidden" name="pertanyaan_id"
                                                                                value="{{ $value->id }}">
                                                                            <input type="hidden" name="lke"
                                                                                value="{{ $lke->id }}">

                                                                            @foreach ($opsi as $item)
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
                                                                        <label for="catatan">Upload Dokumen</label>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr class="text-center">
                                                                                    <th>No</th>
                                                                                    <th>Nama Dokumen</th>
                                                                                    <th>File</th>
                                                                                    <th>Upload</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($dokumen as $item)
                                                                                    @php
                                                                                        $file = App\Models\UploadDokumen::where('dokumenlke_id', $item->id)->get();
                                                                                    @endphp
                                                                                    <tr>
                                                                                        <td>{{ $loop->iteration }}</td>

                                                                                        <td style="min-width: 200px">
                                                                                            {{ $item->dokumen }}
                                                                                            <input type="hidden"
                                                                                                name="id{{ $loop->iteration }}"
                                                                                                value="{{ $item->id }}">
                                                                                        </td>
                                                                                        <td class="text-center">
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
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="d-flex justify-content-between mr-3">
                                                                        <button type="button" class="btn btn-success"
                                                                            data-toggle="modal"
                                                                            data-target="#dokumen{{ $value->id }}"><i
                                                                                class="fas fa-upload">
                                                                                Upload Dokumen</i></button>
                                                                        <button type="submit" class="btn btn-primary"><i
                                                                                class="fas fa-save"></i>
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </td>


                                                                <td style="min-width: 150px;">
                                                                    <p>Bukti Dukung:</p>
                                                                    <ul>
                                                                        @foreach ($dokumen as $item)
                                                                            <li>{{ $item->dokumen }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                    {!! $value->info !!}
                                                                </td>
                                                            </form>
                                                        @endforeach
                                                    @else
                                                        {{-- Create --}}
                                                        <form method="POST" action="/selfAssessment"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <td style="min-width: 550px;">
                                                                <div class="card-body">

                                                                    <div class="form-group">
                                                                        <label
                                                                            for="pertanyaan">{{ $value->pertanyaan }}</label>
                                                                        <input type="hidden" name="pertanyaan_id"
                                                                            value="{{ $value->id }}">
                                                                        <input type="hidden" name="lke"
                                                                            value="{{ $lke->id }}">

                                                                        @foreach ($opsi as $item)
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
                                                                        @foreach ($dokumen as $item)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>

                                                                                <td style="min-width: 200px">
                                                                                    {{ $item->dokumen }}
                                                                                    <input type="hidden"
                                                                                        name="id{{ $loop->iteration }}"
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
                                                                <hr>
                                                                <div class="d-flex justify-content-end mr-3">

                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fas fa-save"></i>
                                                                        Simpan
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td style="min-width: 150px;">
                                                                <p>Bukti Dukung:</p>
                                                                <ul>
                                                                    @foreach ($dokumen as $item)
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

        <a href="/lke/{{ $lke->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
            Kembali</a>
    </div>
@endsection
