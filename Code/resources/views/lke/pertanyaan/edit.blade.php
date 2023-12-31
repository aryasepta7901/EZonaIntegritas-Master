@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <form method="post" action="/pertanyaan/{{ $pertanyaan->id }}">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="text" class="form-control @error('pertanyaan') is-invalid  @enderror"
                                    id="pertanyaan" name="pertanyaan"
                                    value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}" placeholder="Isi  pertanyaan">
                                @error('pertanyaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="@error('info') text-danger  @enderror" for="info">Informasi</label>
                            @error('info')
                                <small class="badge badge-danger"> *{{ $message }}
                                </small>
                            @enderror
                            <textarea id="summernote" name="info">
                                    {{ old('info', $pertanyaan->info) }}
                            </textarea>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="bobot">Bobot</label>
                                <input type="number" class="form-control @error('bobot') is-invalid  @enderror"
                                    id="bobot" name="bobot" value="{{ old('bobot', $pertanyaan->bobot) }}"
                                    placeholder="Isi Nilai Bobot" min="0" step=".01">
                                @error('bobot')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select id="type" class="form-control opsi" name="type">
                                    @php
                                        $type = $opsi->first()->type;
                                    @endphp
                                    @php
                                        $jumlah = $opsi->count('type');
                                    @endphp


                                    <option value="">Pilih Salah Satu </option>
                                    <option @if ($jumlah == 2) selected @endif value="checkbox1">Ya/Tidak
                                    </option>
                                    <option @if ($jumlah == 3) selected @endif value="checkbox2">A/B/C
                                    </option>
                                    <option @if ($jumlah == 4) selected @endif value="checkbox3">A/B/C/D
                                    </option>
                                    <option @if ($jumlah == 5) selected @endif value="checkbox4">A/B/C/D/E
                                    </option>
                                    <option @if ($type == 'input') selected @endif value="input">Input Value
                                    </option>

                                </select>
                            </div>

                        </div>


                        <div class="col-lg-12">
                            <label for="opsi">Opsi</label>
                            <hr>
                        </div>
                        {{-- Input --}}
                        <div id="input" class="col-lg-12 mb-2">
                            <button id="row" type="button" class="btn btn-primary">
                                <i class="fa fa-plus">
                                </i> Tambah
                            </button>
                        </div>

                        @foreach ($opsiInput as $value)
                            <div id="input" class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button id="row" class="btn btn-danger" id="DeleteRow" type="button"><i
                                                    class="bi bi-trash"></i>Delete</button>
                                        </div>
                                        <input type="text" class="form-control" id="opsi" name="input[]" required
                                            placeholder="Isi  Nama Dokumen" value="{{ $value->rincian }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div id="new" class="col-lg-12"></div>
                        {{-- Checbox --}}
                        @foreach ($opsiCheckbox as $value)
                            <div id="checkbox{{ $jumlah - 1 }}" class="col-lg-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="opsi" name="rinci[]"
                                        placeholder="Isi  Nama Dokumen" value="{{ $value->rincian }}">
                                    <input type="hidden" name="bobot{{ $loop->iteration }}" value="{{ $value->bobot }}">
                                    <span class="input-group-text">{{ $value->bobot }}</span>
                                </div>
                            </div>
                        @endforeach



                        {{-- Opsi Pilihan --}}

                        <div class="col-lg-12" id="inputContainer"></div>



                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <label for="dokumen">Dokumen</label>
                            <button id="rowAdder" type="button" class="btn btn-dark">
                                <span class="fa fa-plus">
                                </span>
                            </button>
                            <hr>
                        </div>
                        @foreach ($dokumen as $value)
                            <div id="rowAdder" class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-danger" id="DeleteRow" type="button"><i
                                                    class="bi bi-trash"></i>Delete</button>
                                        </div>
                                        <input required type="text" class="form-control" id="dokumen"
                                            name="dokumen[]" placeholder="Isi  Nama Dokumen"
                                            value="{{ $value->dokumen }}">

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div id="newinput" class="col-lg-12"></div>
                    </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer justify-content-between">
                @php
                    $kembali = substr($subPilar, 0, 4);
                @endphp
                <a href="/pertanyaan" class="btn btn-secondary"><i class="fa fa-backward"></i>
                    Kembali</a>
                {{-- <a href="/subpilar/{{ $kembali }}" class="btn btn-secondary"><i class="fa fa-backward"></i>
                    Kembali</a> --}}
                <button type="submit" class="btn btn-primary">Ubah Pertanyaan</button>
                </form>

            </div>
        </div>
    </div>
@endsection
