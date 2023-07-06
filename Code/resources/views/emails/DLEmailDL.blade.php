@component('mail::message')
# Yth {{ $data['name'] }}

{{ $data['status'] }} telah melakukan penilaian evaluasi terhadap {{ $data['nama_satker'] }} dengan nilai <b>{{ $data['nilai'] }}</b>,
Silahkan lakukan penilaian evaluasi terhadap LKE yang telah dikirimkan

@component('mail::button', ['url' => env('APP_URL').'tpi/evaluasi'])
Penilaian Evaluasi
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
