<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ParcelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParcelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parcelTypeData=ParcelType::orderBy('id','desc')->get();

        if(!empty($parcelTypeData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'parcelTypeData'   =>  $parcelTypeData,
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
            'parcel_type_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(ParcelType::create($data)){
            return response()->json([
                'Messege' => 'Data Insert successfully',
                'Parcel Type' => $data
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
        $parcelType = ParcelType::find($id);
        if(!empty($parcelType)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'parcelType'   =>  $parcelType
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
            'parcel_type_name'=> 'required',
        ]);


        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $parcelType = ParcelType::find($id);
        if($parcelType->update($data)){
            return response()->json([
                'Messege' => 'Data update successfully',
                'ParcelType' => $data
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
        $parcelType = ParcelType::find($id);

        if($parcelType->delete()){
            return response()->json([
                'Messege' => 'Data Delete successfully',
            ], 201);
        }
        else{
            return response()->json([
                'error' => 'error !! Parceltype Delete Failed .',
            ], 500);
        }
    }
}
