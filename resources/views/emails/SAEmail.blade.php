@component('mail::message')


Kepada Tim Evaluator {{ $data['prov'] }}, diberitahukan bahwa Satker {{ $data['kabkota'] }} telah mengirimkan LKE
dengan Nilai Self Assessment <b>{{ $data['nilai'] }}</b>,
Silahkan Lakukan Penilaian Pendahuluan terhadap Satker Tersebut.

@component('mail::button', ['url' => env('APP_URL').'/prov/evaluasi'])
Penilaian Pendahuluan
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
