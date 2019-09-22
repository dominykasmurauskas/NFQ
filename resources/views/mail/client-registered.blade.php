@component('mail::message')
# Registracija sėkminga

Sveiki! Jūsų registracija buvo patvirtinta. <br>
Registracijos duomenys: <br>

Bilietėlio nr.: {{ $client->ticket }}<br>
Kliento vardas ir pavardė: {{ $client->name }} <br>
Paslaugos nr.: {{ $client->service }}<br>
Numatytas vizito laikas: {{ $client->estimated_visit_time }}<br>
Jums liko laukti: {{ $client->timeleft() }}h<br>

<b>Pastaba: </b> jeigu matote, kad jums liko 0:00 iki vizito, tai reiškia, kad kreiptis pas specialistą galite iš karto.

@component('mail::button', ['url' => '/client/' . $client->special_key])
Peržiūrėti kliento puslapį
@endcomponent

Jūsų,<br>
{{ config('app.name') }}
@endcomponent
