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
                        @if (auth()->user()->level_id == 'AT')
                            @php
                                $data = $anggota->pengawasan;
                            @endphp
                        @elseif(auth()->user()->level_id == 'KT')
                            @php
                                $tpi = $ketua->id;
                                $data = App\Models\Pengawasan::where('tpi_id', $tpi)->get();
                            @endphp
                        @elseif(auth()->user()->level_id == 'DL')
                            @foreach ($dalnis as $d)
                                @php
                                    $tpi[] = $d->id;
                                    
                                    $data = App\Models\Pengawasan::whereIn('tpi_id', $tpi)->get();
                                    
                                @endphp
                            @endforeach
                        @endif
                        @foreach ($data as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->satker->nama_satker }}</td>
                                @if ($value->rekapitulasi->count() != 0)
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
                                            <button class="btn btn-info btn-sm m-2" data-toggle="modal"
                                                data-target="#surat_rekomendasi{{ $item->satker_id }}"><i
                                                    class="fas fa-file">
                                                </i></button>
                                        </td>
                                        <td class="text-center">
                                            <a type="button" href="/tpi/evaluasi/{{ $item->id }}"
                                                class="btn btn-sm btn-success"><i class="fa fa-file"></i> LKE</a>
                                        </td>

                                        <td>{{ $item->StatusRekap->status }}</td>

                                        <div class="modal fade" id="surat_rekomendasi{{ $item->satker_id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Surat Rekomendasi
                                                            {{ $item->satker->nama_satker }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item"
                                                                src="{{ asset('storage/' . $item->surat_rekomendasi) }}"
                                                                allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @endforeach
                                @else
                                    <td colspan="6" class="text-center"><button class="btn btn-info">Satker Belum
                                            Mengajukan Zona Integritas </button></td>
                                @endif


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
