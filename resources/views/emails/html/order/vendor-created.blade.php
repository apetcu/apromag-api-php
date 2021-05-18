@component('mail::message')
# Comanda #{{$order->id}}

Dragă **{{$vendor->businessName}}**,  


Utilizatorul **{{$order->fullName}}** a plasat o nouă comandă cu numărul **{{$order->id}}**.

@component('mail::button', ['url' => config('app.url').'/dashboard/orders/'.$order->id])
    Vizualizare comandă
@endcomponent

@component('mail::button', ['url' => 'tel:'.$order->phone, 'color'=> 'red'])
    Apelează clientul: {{$order->phone}}
@endcomponent
[...sau îl poți contacta pe whatsapp](https://wa.me/{{$order->phone}})



## Regăsești mai jos detalii privind comanda plasată:

@component('mail::table')
    | Nume          | Preț unitar   | Cantitate | Subtotal  |
    | :------------ | -----------:  | --------: | --------: |
    @foreach($order->products as $product)
    | {{$product->name}} | {{$product->price}} {{$currency}}  | {{$product->quantity}} | {{$product->quantity * $product->price}} {{$currency}} |
    @endforeach
    |  |   | **Subtotal** | {{$order->sub_total}} {{$currency}} |
    |  |   | **Transport**| {{$order->shipping_price}} {{$currency}} |
    |  |   | **Total** | **{{$order->total}} {{$currency}}** |

@endcomponent

@component('mail::panel')
    Folosind panoul de control puteti vedea in timp real comenzile plasate si statusul acestora.
@endcomponent

@component('mail::promotion')
    Trimite sugestii de imbunatatire catre echipa aprozi.ro
@endcomponent

@component('mail::subcopy')
    Atentie! Va trebui sa confirmati aceasta comanda pentru a anunta utilizatorul ca produsele
    se afla in stoc. Fie ca decideti sa faceti acest lucru folosind panoul de control, fie ca veti apela
@endcomponent


@include('signature')
@endcomponent