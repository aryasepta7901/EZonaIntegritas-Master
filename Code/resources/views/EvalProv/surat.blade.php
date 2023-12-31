@extends('layouts.backEnd.main')

@section('content')
    @if ($rekap->count() != 0)
        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">{{ auth()->user()->satker->nama_satker }}</h3>

                    <p class="text-muted text-center">Pengajuan Zona Integritas</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        @foreach ($rekap as $value)
                            <li class="list-group-item">
                                <b>{{ $value->satker->nama_satker }}</b> <a class="float-right">{{ $value->predikat }}</a>
                                {{-- Cek apakah data rekappilar ada didatabase --}}
                                @if ($value->RekapPengungkit->count() != 0)
                                    {{-- Hitung jumlah nilai rincian pengungkit --}}
                                    @foreach ($value->RekapPengungkit as $item)
                                        @php
                                            $nilai_sa = $item->where('rekapitulasi_id', $value->id)->sum('nilai_sa');
                                        @endphp
                                    @endforeach
                                @endif
                                {{-- Hitung jumlah nilai rincian hasil --}}
                                @php
                                    // $nilai = $nilaiHasil->where('satker_id', $value->satker_id)->sum('nilai');
                                    $nilai = 0;
                                @endphp
                                @php
                                    $total = $nilai_sa + $nilai;
                                @endphp
                                <p>Nilai Self Assessment: <button class="badge badge-info">{{ round($total, 2) }}</button>
                                </p>


                            </li>
                        @endforeach
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
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    Upload Surat Pengantar
                </div>
                <div class="card-body">
                    <form action="/prov/surat" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($rekap as $value)
                            <input type="hidden" value="{{ $value->id }}" name="id[]">
                            <input type="hidden" value="{{ $value->satker_id }}" name="satker[]">
                        @endforeach
                        <input type="hidden" name="satker_id" value="{{ auth()->user()->satker_id }}">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="upload" name="surat"
                                accept="application/pdf">
                            <label class="custom-file-label" for="upload">
                                Upload</label>
                        </div>

                        @if ($rekap->first()->LHE->surat_pengantar_prov)
                            <table class="table table-bordered table-striped mt-3">
                                <thead>
                                    <tr class="text-center">
                                        <th>File</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal"
                                                data-target="#surat_pengantar_prov"><i class="fas fa-file">
                                                </i></button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#hapus"><i class="fa fa-trash"></i></button>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <b>{{ auth()->user()->satker->nama_satker }}</b>
                        <button class="btn btn-primary " data-toggle="modal" data-target="#download"><i
                                class="fas fa-download">
                            </i> Download Template
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <p>Berikut dilampirkan template surat pengantar BPS Provinsi</p>
                    <p>Langkah-Langkah:</p>
                    <ol>
                        <li>Download Templete <badge class="text-info">.docx</badge>
                        </li>
                        <li>Sesuaikan dan ubah kalimat yang <badge class="text-danger">warna merah</badge>
                        </li>
                        <li>Print surat dan berikan tanda tangan kepala BPS Provinsi</li>
                        <li>Scan surat dan upload ke website kembali dengan format <badge class="text-info">.pdf</badge>
                        </li>
                    </ol>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    @else
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissible">
                <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                Satuan kerja belum ada yang disetujui, Silahkan setujui terlebih dahulu sebelum membuat surat persetujuan.
            </div>
        </div>

    @endif



    {{-- Hapus Surat --}}
    @if ($rekap->count() != 0)
        <div class="modal fade" id="hapus">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Hapus</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">
                            Apakah Anda
                            Yakin untuk
                            Menghapus
                            Surat Pengantar dari {{ auth()->user()->satker->nama_satker }}</p>

                    </div>
                    <form action="/prov/surat/{{ $value->id }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        @foreach ($rekap as $value)
                            <input type="hidden" value="{{ $value->id }}" name="id[]">
                        @endforeach
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="surat_pengantar_prov">
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
                                src="{{ asset('storage/' . $rekap->first()->LHE->surat_pengantar_prov) }}"
                                allowfullscreen></iframe>
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
    @endif
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
                <form action="/prov/surat/cetak" method="post">
                    @csrf
                    <input type="hidden" name="satker" value="{{ auth()->user()->satker->nama_satker }}">

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
