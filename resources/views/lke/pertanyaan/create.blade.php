@extends('layouts.backEnd.main')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <form method="post" action="/pertanyaan">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="subpilar_id" value="{{ $subPilar->id }}">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="text" class="form-control @error('pertanyaan') is-invalid  @enderror"
                                    id="pertanyaan" name="pertanyaan" value="{{ old('pertanyaan') }}"
                                    placeholder="Isi  pertanyaan">
                                @error('pertanyaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="info">Informasi</label>
                            <textarea id="summernote" name="info">
                                    {{ old('info') }}
                                </textarea>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="bobot">Bobot</label>
                                <input type="number" class="form-control @error('bobot') is-invalid  @enderror"
                                    id="bobot" name="bobot" value="{{ old('bobot') }}" placeholder="Isi Nilai Bobot"
                                    min="0" step=".01">
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
                                <select class="form-control" name="type">
                                    <option selected>Pilih Type Opsi </option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="input">Input Value</option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="dokumen">Dokumen</label>
                            <button id="rowAdder" type="button" class="btn btn-dark">
                                <span class="fa fa-plus">
                                </span>
                            </button>
                        </div>
                        <div class="col-lg-12">
                            <hr>
                            <div class="form-group">
                                <input type="text" class="form-control @error('dokumen') is-invalid  @enderror"
                                    id="dokumen" name="dokumen" value="{{ old('dokumen') }}"
                                    placeholder="Isi  Nama Dokumen">
                            </div>
                        </div>
                        <div id="newinput" class="col-lg-6"></div>

                    </div>

                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer justify-content-between">
                @php
                    $kembali = substr($subPilar->id, 0, 4);
                @endphp
                <a href="/subpilar/{{ $kembali }}" class="btn btn-secondary"><i class="fa fa-backward"></i>
                    Kembali</a>
                <button type="submit" class="btn btn-primary">Create Pertanyaan</button>

            </div>
        </div>
    </div>
@endsection
