@extends('layouts.backEnd.main')

@section('content')
    <div class="col-md-8 col-lg-12">

        <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
            @php
                $subPilar = App\Models\SubPilar::where('pilar_id', $pilar->id)->get(); //untuk mengambil data subPilar
            @endphp

            <div class="card">
                <div class="card-header p-0" id="headingOne">
                    <h2 class="mb-0">
                        <button href="#collapseOne"
                            class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link button"
                            data-parent="#accordion" data-toggle="collapse" aria-expanded="true"
                            aria-controls="collapseOne">
                            <p class="mb-0">{{ $subPilar[0]->subPilar }} ({{ $subPilar[0]->bobot }})</p>
                            <div class="d-flex justify-content-between ">
                                <p class="info-box-number m-4">Nilai : 0</p>

                                <i class="fa my-4 " aria-hidden="true"></i>

                            </div>
                        </button>
                    </h2>
                </div>
                <div class="collapse show" id="collapseOne" role="tabpanel" aria-labelledby="headingOne">

                    <div class="card-body">
                        @php
                            $pertanyaan = App\Models\Pertanyaan::where('subpilar_id', $subPilar[0]->id)->get(); //untuk mengambil data pertanyaan pertama
                        @endphp
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pertanyaan</h3>
                            </div>
                            <hr>
                            <div class="card-body">
                                @foreach ($pertanyaan as $value)
                                    @php
                                        $opsi = App\Models\Opsi::where('pertanyaan_id', $value->id)->get(); //untuk mengambil data Opsi
                                        $dokumen = App\Models\dokumenLKE::where('pertanyaan_id', $value->id)->get(); //untuk mengambil data Opsi
                                    @endphp
                                    <div class="card-body">
                                        <div class="form-group">

                                            <label for="pertanyaan">{{ $value->pertanyaan }}</label>
                                            <button class="btn  btn-sm btn-info flex-right ml-4" data-toggle="modal"
                                                data-target="#info{{ $value->id }}"><i class="fa fa-info"></i></button>

                                            @foreach ($opsi as $value)
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" name="radio1">
                                                    <label class="form-check-label">{{ $value->rincian }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <textarea class="form-control" rows="4" name="catatan" required>{{ old('catatan') }} </textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mr-3">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                            Simpan
                                        </button>
                                    </div>

                                    <hr>
                                @endforeach
                                {{-- Info --}}
                                @foreach ($pertanyaan as $value)
                                    <div class="modal fade" id="info{{ $value->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Informasi</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
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
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>



            @foreach ($subPilar->skip(1) as $value)
                <div class="card">
                    <div class="card-header p-0" id="heading{{ $loop->iteration }}" role="tab">
                        <h2 class="mb-0">
                            <button href="#collapse{{ $loop->iteration }}"
                                class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link button"
                                data-parent="#accordion" data-toggle="collapse" aria-expanded="false"
                                aria-controls="collapse{{ $loop->iteration }}">

                                <p class="mb-0">{{ $value->subPilar }} ({{ $value->bobot }})</p>
                                <div class="d-flex justify-content-between ">
                                    <p class="info-box-number m-4">Nilai : 0</p>

                                    <i class="fa my-4 " aria-hidden="true"></i>

                                </div>

                            </button>
                        </h2>
                    </div>
                    <div class="collapse " id="collapse{{ $loop->iteration }}" role="tabpanel"
                        aria-labelledby="heading{{ $loop->iteration }}">
                        <div class="card-body">
                            @php
                                $pertanyaan = App\Models\Pertanyaan::where('subpilar_id', $value->id)->get(); //untuk mengambil data pertanyaan pertama
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pertanyaan</h3>
                                </div>
                                <hr>
                                <div class="card-body">
                                    @foreach ($pertanyaan as $value)
                                        @php
                                            $opsi = App\Models\Opsi::where('pertanyaan_id', $value->id)->get(); //untuk mengambil data Opsi
                                            $dokumen = App\Models\dokumenLKE::where('pertanyaan_id', $value->id)->get(); //untuk mengambil data Opsi
                                        @endphp
                                        <div class="card-body">
                                            <div class="form-group">

                                                <label for="pertanyaan">{{ $value->pertanyaan }}</label>
                                                <button class="btn  btn-sm btn-info flex-right ml-4" data-toggle="modal"
                                                    data-target="#info{{ $value->id }}"><i
                                                        class="fa fa-info"></i></button>

                                                @foreach ($opsi as $value)
                                                    <div class="form-check ml-4">
                                                        <input class="form-check-input" type="radio" name="radio1">
                                                        <label class="form-check-label">{{ $value->rincian }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="form-group">
                                                <label for="catatan">Catatan</label>
                                                <textarea class="form-control" rows="4" name="catatan" required>{{ old('catatan') }} </textarea>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mr-3">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Simpan
                                            </button>
                                        </div>

                                        <hr>
                                    @endforeach

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>

                </div>
                {{-- Info --}}
                @foreach ($pertanyaan as $value)
                    <div class="modal fade" id="info{{ $value->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Informasi</h4>
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

        </div>
        <a href="/lke/{{ $lke->id }}" class="btn btn-secondary ml-2 mb-3"><i class="fa fa-backward"></i>
            Kembali</a>
    </div>
@endsection
