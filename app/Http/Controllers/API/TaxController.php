<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the tax data...
        $taxData=Tax::orderBy('id','desc')->get();

        if(!empty($taxData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'taxData'   =>  $taxData,
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
            'tax_name'=> 'required',
            'tax'=> 'required',
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
        if(Tax::create($data)){
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
        $taxData = Tax::find($id);
        if(!empty($taxData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'taxData'   =>  $taxData
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
            'tax_name'=> 'required',
            'tax'=> 'required',
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

        //To fetch single unit data...
        $taxData = Tax::find($id);

        if($taxData->update($data)){
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
        $tax = Tax::find($id);

        $defaultTax = Tax::where('is_default', true)->first();
        $defaultTaxId = $defaultTax->id;

        if($tax->is_default == false){

            //To check product under this tax...
            $this->updateProductTaxId($tax->id, $defaultTaxId);

            if($tax->delete()){
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
				'message'   =>  'error','Error !! This is default Tax, so you can not delete.!'
			], 500);
        }
    }

    //To update default TaxId  into products....
    public function updateProductTaxId($taxId,$defaultTaxId)
    {
        //To check product under this brand...
        $getAllProductIds = Product::where('tax_id', $taxId)->pluck('id');
        Product::whereIn('id', $getAllProductIds)->update(['tax_id' => $defaultTaxId]);
    }


    // Activate taxDefault
    function activeDefaultTax($id){
        //To get all the unit ids...
        $getAllTaxIds = Tax::pluck('id');

        Tax::whereIn('id', $getAllTaxIds)->update(['is_default' => false]);

        if(Tax::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'Tax default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    //To inactive default tax...
    public function inActiveDefaultTax($id)
    {
        if(Tax::where('id', $id)->update(['is_default' => false])){
            return response()->json([
                'message' => 'tax non-default set successfully.'
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.!'
            ], 500);
        }
    }
}
