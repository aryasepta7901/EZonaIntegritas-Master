@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
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

            <!-- /.card-header -->
            <div class="card-header d-flex justify-content-end">


            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kabupaten/Kota</th>
                            <th>Predikat</th>
                            <th>Nilai Pengungkit</th>
                            <th>Nilai Hasil</th>
                            <th>Surat Rekomendasi</th>
                            <th>LKE</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggota->pengawasan as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>

                                @foreach ($value->rekapitulasi as $item)
                                    <td>{{ $item->predikat }}</td>
                                    <td>
                                        {{-- Hitung jumlah nilai rincian pengungkit --}}
                                        @foreach ($item->RekapPilar as $P)
                                            @php
                                                $nilai = $P->where('rekapitulasi_id', $item->id)->sum('nilai_sa');
                                            @endphp
                                        @endforeach
                                        {{ $nilai }}
                                    </td>
                                    <td>
                                        {{-- Hitung jumlah nilai rincian hasil --}}
                                        @php
                                            $nilaiHasil = App\Models\RekapHasil::where('satker_id', $item->satker_id)
                                                ->where('tahun', date('Y'))
                                                ->get();
                                        @endphp
                                        @foreach ($nilaiHasil as $H)
                                            @php
                                                $nilaiHasil = $H->where('satker_id', $item->satker_id)->sum('nilai');
                                            @endphp
                                        @endforeach
                                        {{ $nilaiHasil }}
                                    </td>
                                    <td class="text-center">
                                        <a target="__self" href="{{ asset('storage/' . $item->surat_rekomendasi) }}"><i
                                                class="fas fa-file"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a type="button" href="/tpi/evaluasi/{{ $item->id }}"
                                            class="btn btn-sm btn-success"><i class="fa fa-file"></i> LKE</a>
                                    </td>

                                    <td>{{ $item->StatusRekap->status }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
