@component('mail::message')
# Yth PIC Satuan Kerja {{ $data['nama_satker'] }}

Tim Penilai Internal Inspektorat Utama telah melakukan penilaian evaluasi terhadap {{ $data['nama_satker'] }},
dan memutuskan bahwa LKE <b>{{ $data['status'] }}</b>,{{ $data['pesan'] }}

@component('mail::button', ['url' => env('APP_URL').'satker/lke'])
LKE
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
