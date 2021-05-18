@component('mail::message')
# Resetare parolă

Dragă {{$name}},  
Ai cerut resetarea parolei contului tău.

Pentru a obține acest lucru, te rugăm să accesezi următorul link:  

@component('mail::button', ['url' => config('app.url').'/auth/password-reset/'.$uuid])
    Resetare parolă
@endcomponent

Dacă nu ai inițiat acest proces, te rugăm să ne contactezi de urgență la adresa de e-mail office@aprozi.ro 
sau prin oricare mijloc de comunicare afișat pe site în secțiunea 
[CONTACT](https://www.aprozi.ro/contact)

@include('signature')
@endcomponent