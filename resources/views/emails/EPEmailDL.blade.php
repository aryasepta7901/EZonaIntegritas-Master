@component('mail::message')


Kepada Tim Penilai Internal, diberitahukan bahwa Satker berikut telah mengirimkan LKE
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
| Satker        | Predikat       
| :-------------: |:-------------:|
@foreach ($data['rekapitulasi'] as $value)
| {{ $value->satker->nama_satker }}     | {{ $value->predikat }}      |
@endforeach


@endcomponent
Silahkan Lakukan Penilaian Evaluasi terhadap Satker Tersebut.

@component('mail::button', ['url' => env('APP_URL').'tpi/evaluasi'])
Penilaian Evaluasi
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
