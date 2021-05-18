@component('mail::message')
    # Mesaj nou de la Apromag

    Nume {{$name}},
    Email {{$email}},
    Message {{$message}},

@include('signature')
@endcomponent