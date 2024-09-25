<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the supplier data...
        $supplierData = Supplier::orderBy('id','desc')->get();

        if(!empty($supplierData)){
            return response()->json([
                'message'   =>  'Successfully loaded Supplier data.',
                'supplierData'   =>  $supplierData,
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
            'supplier_name'=> 'required',
            'supplier_phone'=> 'required|min:11',
        ]);

        $data = $request->all();

        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(Supplier::create($data)){

            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'data'   =>  $data,
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
        $supplierData = Supplier::find($id);
        if(!empty($supplierData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'supplierData'   =>  $supplierData
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
            'supplier_name'=> 'required',
            'supplier_phone'=> 'required|min:11',
        ]);

        $data = $request->all();

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        //To fetch single supplier data...
        $supplierData = Supplier::find($id);

        if($supplierData->update($data)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'data'   =>  $data,
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
        $supplier= Supplier::find($id);
        if($supplier->delete()){
            return response()->json([
                'deleteData' => 'Supplier delete successfully',
            ], 201);
        }

        else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }
}
