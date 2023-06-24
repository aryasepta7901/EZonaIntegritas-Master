@component('mail::message')
# Yth Tim Penilai Internal Inspektorat Utama BPS RI

Satuan Kerja {{ $data['nama_prov'] }} telah melakukan penilaian pendahuluan. 
Berikut nama satuan kerja yang diajukan
@component('mail::table')
{{-- <table>
    <thead>
        <tr>
            <th>Satker</th>
            <th>Predikat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['rekapitulasi'] as $value)
        <tr>
            <td class="text-center">{{ $value->satker->nama_satker }}</td>
            <td class="text-center">{{ $value->predikat }}</td>
        </tr>     
        @endforeach
    </tbody>
</table> --}}
| Satker        | Predikat    | Nilai   
| :-------------: |:-------------:|:-------------:|
@foreach ($data['rekapitulasi'] as $value)
@foreach ($value->RekapPengungkit as $item)
@php
    $nilai_sa = $item->where('rekapitulasi_id', $value->id)->sum('nilai_sa');
@endphp
@endforeach
| {{ $value->satker->nama_satker }}     | {{ $value->predikat }}      | {{ round($nilai_sa, 2) }}
@endforeach


@endcomponent
Silahkan Lakukan Penilaian Evaluasi terhadap Satker Tersebut.

@component('mail::button', ['url' => env('APP_URL').'tpi/evaluasi'])
Penilaian Evaluasi
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
