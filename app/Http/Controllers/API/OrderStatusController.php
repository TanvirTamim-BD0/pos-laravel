<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderStatus=OrderStatus::orderBy('id','desc')->get();

        if(!empty($orderStatus)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'orderStatus'   =>  $orderStatus,
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry you have no data.'
			], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_status_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(OrderStatus::create($data)){
            return response()->json([
                'Messege' => 'Data Insert successfully',
                'OrderStatus' => $data
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! Data load.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderStatus = OrderStatus::find($id);
        if(!empty($orderStatus)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'orderStatus'   =>  $orderStatus
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Sorry there have no data.'
			], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_status_name'=> 'required',
        ]);


        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $orderStatus = OrderStatus::find($id);
        if($orderStatus->update($data)){
            return response()->json([
                'Messege' => 'Data update successfully',
                'OrderStatus' => $data
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! Data load.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderStatus = OrderStatus::find($id);

        if($orderStatus->delete()){
            return response()->json([
                'Messege' => 'Data Delete successfully',
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! Delete Failed .',
            ], 500);
        }
    }
}
