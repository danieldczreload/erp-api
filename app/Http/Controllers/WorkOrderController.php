<?php

namespace App\Http\Controllers;

use App\order_item;
use App\work_order;
use Illuminate\Http\Request;

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
}
