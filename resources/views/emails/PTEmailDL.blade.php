@component('mail::message')
# Yth Tim Penilai Internal Inspektorat Utama BPS RI

PIC Satuan kerja {{ $data['namaSatker'] }} telah melakukan revisi LKE
dengan perbaikan nilai Self-Assessment <b>{{ $data['nilai'] }}</b>,
Silahkan lakukan penilaian evaluasi terhadap satker Tersebut.
@component('mail::button', ['url' => env('APP_URL').'tpi/evaluasi'])
Penilaian Evaluasi
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
