<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerdata = Customer::orderBy('id','desc')->get();
        if(!empty($customerdata)){
            return response()->json([
                'Messege' => 'Data load successfully',
                'customer' => $customerdata,
            ], 201);
        }
        else{
            return response()->json([
                'Messege' => 'there is no data.',
            ], 201);
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
            'customer_name'=> 'required',
            'customer_phone'=> 'required|min:11',

        ]);

        $data = $request->all();
        // to check user role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(Customer::create($data)){

            return response()->json([
                'success' => 'Customer Data successfully added',
                'AddNewCustomer' => $data,
            ], 201);
        }else{

            return response()->json([
                'error' => 'Sorry somethig is wrong.'
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
        $customerData = Customer::find($id);
        if(!empty($customerData)){
            return response()->json([
                'success' => 'Customer Single data successfully loaded.',
                'customerData' => $customerData
            ], 201);
        }

        else{
            return response()->json([
                'error' => 'there is no customer single data.'
            ], 201);
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
            'customer_name'=> 'required',
            'customer_phone'=> 'required|min:11',

        ]);

        $data = $request->all();
        // to check user role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $customer = Customer::find($id);

        if($customer->update($data)){

            return response()->json([
                'success' => 'Update Customer Data successfully added',
                'AddNewCustomer' => $data,
            ], 201);
        }else{

            return response()->json([
                'error' => 'Sorry somethig is wrong.'
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
        $customer = Customer::find($id);
        if($customer->delete()){

            return response()->json([
                'deleteData' => 'customer delete successfully',
            ], 201);
        }else{

            return response()->json([
                'error' => 'something is error.',
            ], 500);
        }
    }
}
