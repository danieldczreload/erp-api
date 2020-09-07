@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="opacity: 95%">
        <div class="col-md-12" >
            @if(Session::has('message'))
                <p id = "flash_message"
                   class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
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
                                <button type="button"
                                        class="btn btn-primary accept"
                                        style="font-size: 0.8rem"
                                        value="{{$order->id}}"
                                        data-toggle="modal" data-target="#exampleModal">
                                    Accept
                                </button>
                                <button type="button" class="btn btn-secondary cancel" style="font-size: 0.8rem" value="{{$order->id}}">
                                    Cancel
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Accept Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route("accept.order")}}" method="post" name = 'acceptForm' id = "acceptForm">
                        @csrf
                    <div class="form-group row">
                        <label for="po_number" class="col-sm-3 col-form-label ">ERP to accept</label>
                        <div class="col-sm-9">
                            <select id="erp" name="erp" class="form-control" required>
                                <option></option>
                                <option value="Artfx">Artfx</option>
                                <option value="New Holland">New Holland</option>
                                <option value="Decotex">Decotex</option>
                            </select>
                            <input type="hidden" id="order_id_accept" name="order_id_accept" />
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelButton">Close</button>
                    <button type="button" class="btn btn-primary" id="acceptButton">Accept</button>
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

        .toggle-content {
            display: none;
            height: 0;
            opacity: 0;
            overflow: hidden;
            transition: height 350ms ease-in-out, opacity 750ms ease-in-out;
        }

        .toggle-content.is-visible {
            display: block;
            height: auto;
            opacity: 1;
        }
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
            let accept = document.querySelectorAll(".accept");
            let cancel = document.querySelectorAll(".cancel");
            let selectErp = document.querySelector("#erp");
            let orderIdAccept = document.querySelector("#order_id_accept");
            let acceptForm = document.querySelector("#acceptForm");
            let acceptButton = document.querySelector("#acceptButton");
            let flashP = document.querySelector("#flash_message");

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

            for (acc of accept){
                acc.onclick = event =>{
                    selectErp.value = ""
                    orderIdAccept.value = event.target.value;
                }
            }

            acceptButton.onclick = event =>{
                if(selectErp.value !== ""){
                    acceptForm.submit();
                }else{
                    swal("Wait!", "Please select an valid ERP", "warning");
                }
            }

            for(can of cancel){
                can.onclick = event =>{
                    let orderId = event.target.value;
                    swal({
                        title: "Are you sure?",
                        text: "This order will be rejected!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                            if (willDelete) {
                                window.location = "/cancel/"+orderId;
                            }
                        });
                }
            }


            if(flashP !== null){
                setTimeout(function(){
                    $(flashP).fadeOut("slow");
                },1200);
            }

        });
    </script>
@endsection
