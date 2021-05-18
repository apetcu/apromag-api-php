@component('mail::message')
# Confirmare Resetare parolă

Dragă {{$name}},

**Parola ta a fost resetată cu succes!**  
Pentru a te loga în contul tău poți accesa link-ul de mai jos:  

@component('mail::button', ['url' => config('app.url').'/auth/login'])
    Login
@endcomponent

Dacă nu ai inițiat acest proces, te rugăm să ne contactezi de urgență la adresa de e-mail office@aprozi.ro
sau prin oricare mijloc de comunicare afișat pe site în secțiunea
[CONTACT](https://www.aprozi.ro/contact)

@include('signature')
@endcomponent