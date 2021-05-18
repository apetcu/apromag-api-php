@component('mail::message')
# {{$action}}

Dragă **{{$order->fullName}}**,  

**{{$vendor->businessName}}** {{$title}} comanda ta cu numărul **{{$order->id}}**!


@component('mail::panel')
    **Observații {{$vendor->businessName}}**:    
    {{$remarks}}
@endcomponent
<br/>


@component('mail::button', ['url' => config('app.url').'/user/orders/'.$order->id])
    Vizualizează comanda
@endcomponent

@component('mail::button', ['url' => 'tel:'.$vendor->phone, 'color'=> 'red'])
    Apelează producătorul: {{$vendor->phone}}
@endcomponent
[...sau îl poți contacta pe whatsapp](https://www.wa.me/{{$vendor->phone}})

## Regăsești mai jos detalii privind comanda expediată:

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

Mai multe informații despre comanda ta vei găsi în secțiunea **Comenzi** din [contul de client]({{ config('app.url') }}/user/orders).

@include('signature')
@endcomponent