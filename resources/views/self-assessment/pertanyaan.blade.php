@extends('layouts.backEnd.main')

@section('content')
    <div class="col-md-8 col-lg-12">
        <div id="accordion" class="myaccordion w-100" aria-multiselectable="true">
            @php
                $subPilar = App\Models\SubPilar::where('pilar_id', $pilar->id)->get();
            @endphp
            <div class="card">
                <div class="card-header p-0" id="headingOne">
                    <h2 class="mb-0">
                        <button href="#collapseOne"
                            class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link"
                            data-parent="#accordion" data-toggle="collapse" aria-expanded="true"
                            aria-controls="collapseOne">
                            <p class="mb-0">{{ $subPilar[0]->subPilar }}</p>
                            <i class="fa" aria-hidden="true"></i>
                        </button>
                    </h2>
                </div>
                <div class="collapse show" id="collapseOne" role="tabpanel" aria-labelledby="headingOne">
                    <div class="card-body py-5 px-4">
                        <ol>
                            <li>Far far away, behind the word mountains</li>
                            <li>Consonantia, there live the blind texts</li>
                            <li>When she reached the first hills of the Italic Mountains</li>
                            <li>Bookmarksgrove, the headline of Alphabet Village</li>
                            <li>Separated they live in Bookmarksgrove right</li>
                        </ol>
                    </div>
                </div>
            </div>

            @foreach ($subPilar->skip(1) as $value)
                <div class="card">
                    <div class="card-header p-0" id="heading{{ $loop->iteration }}" role="tab">
                        <h2 class="mb-0">
                            <button href="#collapse{{ $loop->iteration }}"
                                class="d-flex py-4 px-4 align-items-center justify-content-between btn btn-link"
                                data-parent="#accordion" data-toggle="collapse" aria-expanded="false"
                                aria-controls="collapse{{ $loop->iteration }}">
                                <p class="mb-0">{{ $value->subPilar }}</p>
                                <i class="fa" aria-hidden="true"></i>
                            </button>
                        </h2>
                    </div>
                    <div class="collapse " id="collapse{{ $loop->iteration }}" role="tabpanel"
                        aria-labelledby="heading{{ $loop->iteration }}">
                        <div class="card-body py-5 px-4">
                            <ol>
                                <li>Far far away, behind the word mountains</li>
                                <li>Consonantia, there live the blind texts</li>
                                <li>When she reached the first hills of the Italic Mountains</li>
                                <li>Bookmarksgrove, the headline of Alphabet Village</li>
                                <li>Separated they live in Bookmarksgrove right</li>
                            </ol>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
@endsection
