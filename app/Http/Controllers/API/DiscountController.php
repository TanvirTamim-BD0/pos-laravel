<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the unit data...
        $discountData=Discount::orderBy('id','desc')->get();

        if(!empty($discountData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'discountData'   =>  $discountData,
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
            'discount_name'=> 'required',
            'discount'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 1;

        if(Discount::create($data)){
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
        $discountData = Discount::find($id);
        if(!empty($discountData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'discountData'   =>  $discountData
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
            'discount_name'=> 'required',
            'discount'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $data['status'] = 1;
        $discount = Discount::find($id);

        if($discount->update($data)){

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
        $discount = Discount::find($id);

        if($discount->is_default == false){
            if($discount->delete()){
                return response()->json([
                    'message' => 'Data deleted successfully.'
                ], 201);
            }else{

                return response()->json([
                    'message'   =>  'Something is wrong.!'
                ], 500);
            }
        }else{
            return response()->json([
                'message'   =>  'Error !! This is default Discount, so you can not delete.!'
            ], 500);
        }
    }

    // Activate discountDefault
    function activeDefaultDiscount($id){
        //To get all the unit ids...
        $getAllDiscountIds = Discount::pluck('id');
        $getAllDiscountIds = Discount::pluck('id');
        Discount::whereIn('id', $getAllDiscountIds)->update(['is_default' => false]);

        if(Discount::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'Discount default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    //To inactive default Discount...
    public function inActiveDefaultDiscount($id)
    {
        if(Discount::where('id', $id)->update(['is_default' => false])){
            return response()->json([
                'message' => 'Discount non-default set successfully.'
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.!'
            ], 500);
        }
    }
}
