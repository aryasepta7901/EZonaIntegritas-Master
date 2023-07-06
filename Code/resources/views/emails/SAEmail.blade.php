@component('mail::message')
# Yth  Tim Evaluator {{ $data['prov'] }}


PIC Satuan kerja {{ $data['kabkota'] }} telah mengirimkan LKE
dengan Nilai Self-Assessment <b>{{ $data['nilai'] }}</b>,
silahkan lakukan penilaian pendahuluan terhadap LKE yang telah dikirimkan.

@component('mail::button', ['url' => env('APP_URL').'prov/evaluasi'])
Penilaian Pendahuluan
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
