<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerGroupData = CustomerGroup::orderBy('id','desc')->get();
        if(!empty($customerGroupData)){
            return response()->json([
                'success' => 'Customer Group Data successfully added',
                'AllCustomerGroup' => $customerGroupData
            ], 201);
        }

        else {
            return response()->json([
                'EmpthyData' => 'Sorry there is no data.'
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
            'group_name' => 'required',
            'discount' => 'required',
        ]);

        $data = $request->all();

        // to check user role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(CustomerGroup::create($data)){
            return response()->json([
                'success' => 'Customer Group Data successfully added',
                'AddCustomerGroup' => $data,
            ], 201);
        }

        else{
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
        $customergroupData = CustomerGroup::find($id);
        if(!empty($customergroupData)){
            return response()->json([
                'success' => 'Single data successfully loaded.',
                'customergroupData' => $customergroupData
            ], 201);
        }

        else{
            return response()->json([
                'error' => 'there is no single data.'
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
            'group_name' => 'required',
            'discount' => 'required',
        ]);

        $data = $request->all();

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        // to fetch all single data
        $customerGroup = CustomerGroup::findOrFail($id);

        if($customerGroup->update($data)){
            return response()->json([
                'success' => 'Customer Group Data successfully added',
                'AddCustomerGroup' => $data,
            ], 201);
        }

        else{
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
        $CustomerGroup = CustomerGroup::find($id);

        if($CustomerGroup->delete()){
            return response()->json([
                'deleteData' => 'customerGroup delete successfully',
            ], 201);
        }else{

            return response()->json([
                'error' => 'something is error.',
            ], 500);
        }
    }

    // Activate Customer GroupDefault
    function activeDefaultCustomerGroup($id){
        //To get all the customer Group ids...
        $getAllCustomerGroupIds = CustomerGroup::pluck('id');

        // CustomerGroup::whereIn('id', $getAllCustomerGroupIds)->update(['is_default' => false]);

        if(CustomerGroup::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'CustomerGroup default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

     //To inactive default customerGroup...
     public function inActiveDefaultCustomerGroup($id)
     {
         if(CustomerGroup::where('id', $id)->update(['is_default' => false])){
             return response()->json([
                 'message' => 'CustomerGroup non-default set successfully.'
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Something is wrong.!'
             ], 500);
         }
     }
}
