@component('mail::message')
# Yth PIC Satuan Kerja {{ $data['kabkota'] }}

Tim Evaluator   {{ $data['prov'] }} telah melakukan penilaian pendahuluan 
dan memutuskan bahwa LKE <b>{{ $data['status'] }}</b>
,{{ $data['pesan'] }}
@component('mail::button', ['url' => env('APP_URL').'satker/lke'])
LKE
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
