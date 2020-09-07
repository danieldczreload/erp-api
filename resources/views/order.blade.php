<br />

<label for=""><b>Order accepted at: </b> {{$order->erp}}</label>
<br /><br />
<table style="border: 1px solid #dee2e6;
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;" border = "1">
    <thead>
    <tr style="background-color: aliceblue;">
        <th>PO#</th>
        <th>Client</th>
        <th>Ship Date</th>
        <th>Style</th>
        <th>Color</th>
        <th style="width: 15%">Ship to</th>
        <th>FOB Price</th>
        @foreach($order->order_items->first()->order_item_sizes as $size)
            <th>{{$size->size_name}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$order->order_number}}</td>
        <td>{{$order->client}}</td>
        <td>{{Carbon\Carbon::parse($order->ship_date)->format('m/d/Y')}}</td>
        <td>{{$order->order_items->first()->style}}</td>
        <td>{{$order->order_items->first()->color}}</td>
        <td>{{$order->order_items->first()->ship_info}}</td>
        <td>${{$order->order_items->first()->fob_price}}</td>
        @foreach($order->order_items->first()->order_item_sizes as $size)
            <th>{{$size->qty}}</th>
        @endforeach
    </tr>
    </tbody>
</table>
