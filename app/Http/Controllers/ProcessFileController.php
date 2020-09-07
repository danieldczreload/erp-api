<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProcessFileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the upload file screen
     *
     * @return Renderable
     */
    public function index()
    {
        return view('uploadFile');
    }

    /**
     * @param ProcessFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function process(Request $request)
    {

        $request->validate([
            'file' => "required"
        ]);

        $fileType = $request->file('file')->getClientOriginalExtension();

        if ($fileType == 'json') {

            $jsonContent = json_decode(file_get_contents($request->file('file')->getRealPath()), true);

//            dd($jsonContent);
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

            Validator::make($jsonContent, [
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

            $fileName = time() . '.' . $fileType;

            if(!file_exists(public_path('uploads'))){
                mkdir(public_path('uploads'),0755,true);
            }

            $request->file->move(public_path('uploads'), $fileName);
            Session::flash('message', 'Order was processed!');
            Session::flash('alert-class', 'alert-success');

            return back();
        } else {
            Session::flash('message', 'Please provide a json file!');
            Session::flash('alert-class', 'alert-danger');
            return back();
        }


    }
}
