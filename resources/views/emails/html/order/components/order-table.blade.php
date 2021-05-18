<table cellspacing="0" cellpadding="3" border="0" dir="ltr" class="table">
    <thead dir="ltr">
    <tr dir="ltr">
        <th scope="col" width="53%" dir="ltr"
            style="text-align:left;border-bottom:1px solid #ccc;font-size:16px">Produs
        </th>
        <th scope="col" width="22%" dir="ltr"
            style="text-align:center;border-bottom:1px solid #ccc;font-size:16px">Cantitate
        </th>
        <th scope="col" width="25%" dir="ltr"
            style="text-align:right;border-bottom:1px solid #ccc;font-size:16px">Preț
        </th>

    </tr>
    </thead>
    <tbody dir="ltr">
    @foreach ($products as $product)
        @component('emails.html.order.components.order-item', ['product' => $product])
        @endcomponent
    @endforeach
    </tbody>
    <tfoot dir="ltr">
    <tr dir="ltr">
        <th scope="row" width="75%" colspan="2" dir="ltr"
            style="text-align:right;padding-bottom:3px;padding-right:20px;padding-top:30px;font-weight:300">
            Sub-total:
        </th>
        <td width="25%" dir="ltr"
            style="text-align:right;padding-bottom:3px;padding-top:30px;font-weight:300">
                        <span dir="ltr"><span th:text="${subtotal}"></span>&nbsp;<span
                                    th:text="${currency.getCode()}"></span></span></td>

    </tr>
    <tr dir="ltr">
        <th scope="row" width="75%" colspan="2" dir="ltr"
            style="text-align:right;padding-bottom:3px;padding-right:20px;font-weight:300">
            Livrare:
        </th>
        <td width="25%" dir="ltr"
            style="text-align:right;padding-bottom:3px;font-weight:300"><span
                    th:text="${shippingPrice}"></span> <span th:text="${currency.getCode()}"></span>
        </td>

    </tr>
    <tr dir="ltr">
        <th scope="row" width="75%" colspan="2" dir="ltr"
            style="text-align:right;padding-bottom:3px;padding-right:20px;font-weight:bold">
            Total:
        </th>
        <td width="25%" dir="ltr"
            style="text-align:right;padding-bottom:3px;font-weight:bold">
                        <span dir="ltr"><span th:text="${total}"></span>&nbsp;<span
                                    th:text="${currency.getCode()}"></span></span>
        </td>

    </tr>
    </tfoot>
</table>
