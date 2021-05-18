@component('mail::message')
# Comanda #{{$order->id}}

Dragă **{{$order->fullName}}**,

Am recepționat comanda ta **{{$order->id}}** și am trimis-o către **{{$vendor->businessName}}** urmând ca acesta să o confirme în curând.

@component('mail::promotion')
    **Atenție!**  
    Acest mesaj nu este o confirmare că produsele comandate de tine se află
    în stoc. Confirmarea comenzii se va face în scurt timp de către
    producator și vei primi detalii despre această comandă prin e-mail.
@endcomponent

Regăsești mai jos detalii privind comanda plasată:

@component('mail::button', ['url' => config('app.url').'/user/orders/'.$order->id])
    Vizualizare comanda
@endcomponent


@component('mail::button', ['url' => 'tel:'.$vendor->phone, 'color'=> 'red'])
    Apelează producătorul: {{$vendor->phone}}
@endcomponent
[...sau îl poți contacta pe whatsapp](https://www.wa.me/{{$vendor->phone}})


## Produse:

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



@include('signature')
@endcomponent