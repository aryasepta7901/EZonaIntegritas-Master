@extends('layouts.backEnd.main')

@section('content')

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
                Upload Surat Rekomendasi
            </div>
            <div class="card-body">
                <form action="/tpi/lhe" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload" name="surat">
                        <label class="custom-file-label" for="upload">
                            Upload</label>
                    </div>



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
@endsection
