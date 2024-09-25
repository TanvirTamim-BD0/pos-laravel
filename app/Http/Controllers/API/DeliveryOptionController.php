<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveryOption=DeliveryOption::orderBy('id','desc')->get();

        if(!empty($deliveryOption)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'deliveryOption'   =>  $deliveryOption,
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
            'delivery_type'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(DeliveryOption::create($data)){
            return response()->json([
                'Messege' => 'Data Insert successfully',
                'DeliveryOption' => $data
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
        $deliveryOptionData = DeliveryOption::find($id);
        if(!empty($deliveryOptionData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'deliveryOption'   =>  $deliveryOptionData
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
            'delivery_type'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $deliverOption = DeliveryOption::find($id);

        if($deliverOption->update($data)){
            return response()->json([
                'Messege' => 'Data update successfully',
                'DeliveryOption' => $data
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
        $deliverOption = DeliveryOption::find($id);
        if($deliverOption->delete()){
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
