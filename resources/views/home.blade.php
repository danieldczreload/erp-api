@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="opacity: 95%">
        <div class="col-md-12" >
            <div class="card">
                <div class="card-header text-white" style="background-color: #344b60;">Filters</div>
                <div class="card-body">
                     <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="po_number" class="col-sm-3 col-form-label ">PO#</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control filter" id="po_number">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="client" class="col-sm-3 col-form-label ">Client</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control filter" id="client">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="style" class="col-sm-3 col-form-label ">Style</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control filter" id="style">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="color" class="col-sm-3 col-form-label ">Color</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control filter" id="color">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header text-white" style="background-color: #344b60;">Pending Orders</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                @foreach($orders as $order)
                    <table class="table table-bordered order" data-po_number = "{{$order->order_number}}"
                                                              data-client = "{{$order->client}}"
                                                              data-color = "{{$order->order_items->first()->color}}"
                                                              data-style = "{{$order->order_items->first()->style}}"
                    >
                        <thead>
                            <tr style="background-color: aliceblue;">
                                <th>PO#</th>
                                <th>Client</th>
                                <th>Ship Date</th>
                                <th>Style</th>
                                <th>Color</th>
                                <th style="width: 15%">Ship to</th>
                                <th>FOB Price </th>
                                @foreach($order->order_items->first()->order_item_sizes as $size)
                                    <th>{{$size->size_name}}</th>
                                @endforeach
                                <th style="width: 15%">Actions</th>
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
                            <td>
                                <button type="button" class="btn btn-primary" style="font-size: 0.8rem">Accept</button>
                                <button type="button" class="btn btn-secondary" style="font-size: 0.8rem">Cancel</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    <style>
        td{
            font-size: 0.8rem !important;

        }

        th{
            font-size: 0.8rem !important;
            /*color:white;*/
        }

        /*.table-bordered th, .table-bordered td {
            border: 1px solid black;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }*/


    </style>
@endsection

@section("js")
    <script>
        const ready = function ready(fn) {
            if (document.readyState != 'loading'){
                fn();
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        };

        ready(function(){
            let filters = document.querySelectorAll(".filter");
            let orders = document.querySelectorAll(".order");

            for (const filter of filters) {
                filter.onkeyup =  event => {
                    //
                    for(const order of orders){
                        let ban = true;
                        for (const f of filters){
                            const value = f.value; //valor a buscar
                            const key = f.id;
                            if(value!==""){
                                ban = ban && order.dataset[key].toUpperCase().startsWith(value.toUpperCase());
                            }else{
                                ban = ban && true;
                            }
                        }
                        order.style.display = ban?"":"none";
                    }
                };
            }
        })
    </script>
@endsection
