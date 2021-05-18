@component('mail::message')
# Notificare schimbare e-mail

Dragă {{$name}},  


E-mail-ul tau a fost modificat în: **{{$email}}**  


Dacă nu ai inițiat acest proces, te rugăm să ne contactezi de urgență la adresa de e-mail office@aprozi.ro
sau prin oricare mijloc de comunicare afișat pe site în secțiunea
[CONTACT](https://www.aprozi.ro/contact)

@include('signature')
@endcomponent