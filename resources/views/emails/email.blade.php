@component('mail::message')
# Penilaian Pendahuluan Zona Integritas

Kepada Tim Evaluator {{ $data['prov'] }}, diberitahukan bahwa Satker {{ $data['kabkota'] }} telah mengirimkan LKE
dengan Nilai Self Assessment <b>{{ $data['nilai'] }}</b>,
Silahkan Lakukan Penilaian Pendahuluan terhadap Satker Tersebut

@component('mail::button', ['url' => base_url('/prov/evaluasi')])
    Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
