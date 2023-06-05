@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">Pengajuan Zona Integritas</h3>
                <p class="text-muted text-center"></p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>{{ $rekap->satker->nama_satker }}</b> <a class="float-right">{{ $rekap->predikat }}</a>
                        <p>Nilai Self Assessment:<button class="badge badge-info">
                                {{ round($nilai->sum('nilai_sa'), 2) }}</button></p>
                    </li>
                    <li class="list-group-item">
                        <p>Nilai Desk Evaluation: <button class="badge badge-info">
                                {{ round($nilai->sum('nilai_dl'), 2) }}</button></p>
                        <ul>
                            <li>Pengendali Teknis: {{ $dalnis->name }} </li>
                            <li>Ketua Tim: {{ $ketua->name }}</li>
                            <li>Anggota Tim: {{ $anggota->name }}</li>
                        </ul>

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
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <b> Upload Laporan Hasil Evaluasi</b>
            </div>
            <div class="card-body">
                <form action="/tpi/lhe" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="anggota_id" value="{{ $anggota->id }}">
                    <input type="hidden" value="{{ $rekap->id }}" name="id">
                    <input type="hidden" name="satker_id" value="{{ $rekap->satker_id }}">
                    @if ($pengawasan->tahap == 2)
                        <div class="form-group">
                            <label class="@error('persetujuan') text-danger  @enderror" for="persetujuan">Persetujuan
                                LKE</label>
                            @error('persetujuan')
                                <small class="badge badge-danger"> *{{ $message }}
                                </small>
                            @enderror
                            <select class="form-control" name="persetujuan">
                                <option value="">Pilih Persetujuan</option>
                                <option value="6" @if (old('persetujuan') == 6) selected @endif>Setuju LKE
                                </option>
                                <option value="7" @if (old('persetujuan') == 7) selected @endif>Tolak LKE
                                </option>

                            </select>

                        </div>
                    @endif

                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload" name="lhe"
                            accept="application/pdf">
                        <label class="custom-file-label" for="upload">
                            Upload</label>
                    </div>
                    @if ($rekap->LHE->LHE_1)
                        <table class="table table-bordered table-striped mt-3">
                            <thead>
                                <tr class="text-center">
                                    <th>File</th>
                                    <th>Evaluasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal"
                                            data-target="#lhe1"><i class="fas fa-file">
                                            </i></button>
                                    </td>

                                    <td>
                                        <p class="badge badge-info">Tahap 1</p>
                                    </td>

                                </tr>
                                @if ($rekap->LHE->LHE_2)
                                    <tr>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal"
                                                data-target="#lhe2"><i class="fas fa-file">
                                                </i></button>
                                        </td>
                                        <td>
                                            <p class="badge badge-info">Tahap 2</p> <b>
                                                {{ $rekap->StatusRekap->status }}</b>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    @endif



            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end mr-3">
                    @if ($pengawasan->tahap == 1)
                        <button type="submit" name="submit_1" value="lhe1" class="btn btn-primary"><i
                                class="fas fa-save"></i>
                            Simpan
                        </button>
                    @elseif($pengawasan->tahap == 2)
                        <button type="submit" name="submit_2" value="lhe2" class="btn btn-primary"><i
                                class="fas fa-save"></i>
                            Simpan
                        </button>
                    @endif

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
                    <form action="/tpi/lhe/cetak" method="post">
                        @csrf
                        <input type="hidden" name="satker" value="{{ $rekap->satker->nama_satker }}">
                        <input type="hidden" name="satker_id" value="{{ $rekap->satker_id }}">
                        <input type="hidden" name="wilayah" value="{{ $rekap->satker->wilayah }}">
                        <input type="hidden" name="id" value="{{ $rekap->id }}">
                        <input type="hidden" name="nilaisa" value="{{ $nilai->sum('nilai_sa') }}">
                        <input type="hidden" name="nilaidl" value="{{ $nilai->sum('nilai_dl') }}">
                        {{-- Data TPI --}}
                        <input type="hidden" name="at" value="{{ $anggota->name }}">
                        <input type="hidden" name="id_at" value="{{ $anggota->id }}">
                        <input type="hidden" name="kt" value="{{ $ketua->name }}">
                        <input type="hidden" name="id_kt" value="{{ $ketua->id }}">
                        <input type="hidden" name="dalnis" value="{{ $dalnis->name }}">
                        <input type="hidden" name="id_dl" value="{{ $dalnis->id }}">
                        {{-- Data NilaiPengungkit --}}
                        <button class="btn btn-primary"><i class="fas fa-download"></i></button>
                    </form>

                </div>
            </div>
            <div class="card-body">
                <p>Berikut dilampirkan template Laporan Hasil Evaluasi</p>
                <p>Langkah-Langkah:</p>
                <ol>
                    <li>Download Templete <badge class="text-info">.docx</badge>
                    </li>
                    <li>Sesuaikan dan ubah kalimat yang <badge class="text-danger">warna merah</badge>
                    </li>
                    <li>Print surat dan berikan tanda tangan stakeholder terkait</li>
                    <li>Scan surat dan upload ke website kembali dengan format <badge class="text-info">.pdf</badge>
                    </li>
                </ol>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="modal fade" id="lhe1">
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
                        <iframe class="embed-responsive-item" src="{{ asset('storage/' . $rekap->LHE->LHE_1) }}"
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
    <div class="modal fade" id="lhe2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Laporan Hasil Evaluasi
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ asset('storage/' . $rekap->LHE->LHE_2) }}"
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
@endsection
