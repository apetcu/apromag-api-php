@component('mail::message')
# Bine ai venit in comunitatea {{ config('app.name') }}!

Dragă {{$name}},  

Îți mulțumim pentru alegerea ta. Contul tău a fost creat și poate fi utilizat.
<br/>
<br/>
  
@component('mail::panel')
    **Datele tale:**  
    **Email:** {{$email}}  
    **Parola:** \*\*\*\*\*\*
@endcomponent
<br/>

După logare, veți avea acces la mai multe instrumente precum vizualizarea  
istoricului comenzilor, editarea detaliilor contului și altele.


@include('signature')
@endcomponent