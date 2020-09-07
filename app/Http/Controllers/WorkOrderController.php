<?php

namespace App\Http\Controllers;

use App\order_item;
use App\work_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WorkOrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return work_order[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
       return work_order::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //$order = work_order::create($request->all());
        if($request->isJson()){
            $messages = [
                'order_number' => 'The Order Number is not valid',
                'client' => 'The Client is required',
                'ship_date' => 'The Ship date is not valid',
                'item.style' => 'Style is required',
                'item.color' => 'Color is required',
                'item.ship_info' => 'Ship info is required',
                'item.fob_price' => 'FOB Price is not valid',
                'item.fob_price.numeric' => 'FOB Price is not valid',
                'item.sizes.*.size_name' => 'Size is required',
                'item.sizes.*.qty' => 'Size qty is not valid',
                'item.sizes.*.qty.numeric' => 'Size qty is not valid',
                'item.sizes.*.order_by' => 'Order by is required',
                'item.sizes.*.order_by.numeric' => 'Order by is required',
            ];

           Validator::make($request->all(), [
                'order_number' => 'required',
                'client' => 'required',
                'ship_date' => 'required|date',
                'item.style' => 'required',
                'item.color' => 'required',
                'item.ship_info' => 'required',
                'item.fob_price' => 'required|numeric',
                'item.sizes.*.size_name' => 'required',
                'item.sizes.*.qty' => 'required|numeric',
                'item.sizes.*.order_by' => 'required|numeric',
            ], $messages)->validate();

            $order= work_order::create($request->all());
            $item =$request->get("item");
            /**
             * @var order_item $orderItem
             */
            $orderItem =$order->order_items()->create($item);
            foreach ($item["sizes"] as $size) {
                $orderItem->order_item_sizes()->create($size);
            }

            if($order){
                return response()->json(["message"=>"success"], 201);
            }else{
                return response()->json(["message"=>"Error saving"], 500);
            }



        }else{
            return response()->json(['message'=>"Bad Content Type"], 400);
        }
        //return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\work_order  $work_order
     * @return \Illuminate\Http\Response
     */
    public function show(work_order $work_order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\work_order  $work_order
     * @return \Illuminate\Http\Response
     */
    public function edit(work_order $work_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\work_order  $work_order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, work_order $work_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\work_order  $work_order
     * @return \Illuminate\Http\Response
     */
    public function destroy(work_order $work_order)
    {
        //
    }

    public function sendEmail(int $id){
        $order = work_order::with('order_items.order_item_sizes')
                ->where('id',$id)
                ->get()
                ->sortBy('order_items.order_item_sizes.order_by');
        $order = $order->first();
        try {
            $html = view('order', ["order" => $order])->render();
        } catch (\Throwable $e) {
            $html = "";
        }
        if(!empty($order)){
            Http::post('https://prod-117.westus.logic.azure.com:443/workflows/fadb50194ffa4811b7c38b1c9a4e860c/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=5P9ZHlFkVkK7na2QHo_IspmzQEFYGr9gfOSXb0uab70',
                [
                'html' => $html,
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptOrder(Request $request){
        $work_order = work_order::where('id', $request->get("order_id_accept"))
                                        ->update(array('erp' => $request->get("erp"),"status"=>2));
        if($work_order){
            Session::flash('message', 'Order was accepted!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Order has errors!');
            Session::flash('alert-class', 'alert-danger');
        }
        $this->sendEmail($request->get("order_id_accept"));
        return redirect()->action('HomeController@index');
    }

    public function cancelOrder(int $id){
        $work_order = work_order::where('id', $id)
            ->update(array("status"=>0));
        if($work_order){
            Session::flash('message', 'Order was cancelled!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Error!');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect()->action('HomeController@index');
    }
}
