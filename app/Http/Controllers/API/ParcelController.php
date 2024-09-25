<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\CourierPackage;
use App\Models\DeliveryOption;
use App\Models\OrderStatus;
use App\Models\Parcel;
use App\Models\ParcelType;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parcels = Parcel::orderBy('id', 'desc')->get();

        if(!empty($parcels)){
            return response()->json([
                'Messege' => 'Data load successfully',
                'parcels' => $parcels,
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! Data load.',
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
            // 'order_id'=> 'required',
            'courier_id'=> 'required',
            'courier_package_id'=> 'required',
            'parcel_type_id'=> 'required',
            'order_status_id'=> 'required',
            'delevery_option_id'=> 'required',
            'staff'=> 'required',
        ]);

       $data = $request->all();

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(Parcel::create($data)){
            return response()->json([
                'Messege' => 'Data Insert successfully',
                'Parcel' => $data
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
        $percel = Parcel::find($id);
        if(!empty($percel)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'percel'   =>  $percel
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
            // 'order_id'=> 'required',
            'courier_id'=> 'required',
            'courier_package_id'=> 'required',
            'parcel_type_id'=> 'required',
            'order_status_id'=> 'required',
            'delevery_option_id'=> 'required',
            'staff'=> 'required',
        ]);


        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $parcel = Parcel::find($id);
        if($parcel->update($data)){
            return response()->json([
                'Messege' => 'Data update successfully',
                'Parcel' => $data
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
        $parcel = Parcel::find($id);

        if($parcel->delete()){
            return response()->json([
                'Messege' => 'Successfully Parcel Deleted',
            ], 201);
        }else{
            return response()->json([
                'error' => 'error !! Error !! Delete Failed.',
            ], 500);
        }
    }
}
