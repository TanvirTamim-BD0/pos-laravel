<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the unit data...
        $unitData=Unit::orderBy('id','desc')->get();

        if(!empty($unitData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'unitData'   =>  $unitData,
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
            'unit_name'=>'required',
        ]);

        $data=$request->all();
        // check User role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(Unit::create($data)){
            return response()->json([
                'message' => 'Data saved successfully.',
                'unitData'   =>  $data
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
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
        $unitData = Unit::find($id);
        if(!empty($unitData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'unitData'   =>  $unitData
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
            'unit_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        //To fetch single unit data...
        $unitData = Unit::find($id);

        if($unitData->update($data)){
            return response()->json([
                'message' => 'Data updated successfully.',
                'unitData' =>  $data
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
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
        $unitData = Unit::find($id);
        if($unitData->delete()){
            return response()->json([
                'message' => 'Data deleted successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    // Activate unitDefault
    function activeDefaultUnit($id){
        //To get all the unit ids...
        $getAllunitIds = Unit::pluck('id');
        Unit::whereIn('id', $getAllunitIds)->update(['is_default' => false]);

        if(Unit::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'Unit default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

     //To inactive default unit...
     public function inActiveDefaultUnit($id)
     {
         if(Unit::where('id', $id)->update(['is_default' => false])){
             return response()->json([
                 'message' => 'unit non-default set successfully.'
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Something is wrong.!'
             ], 500);
         }
     }
}
