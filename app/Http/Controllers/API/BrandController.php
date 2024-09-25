<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the brand data...
        $brandData=Brand::orderBy('id','desc')->get();

        if(!empty($brandData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'brandData'   =>  $brandData,
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
            'brand_name'=>'required',
            'brand_image'=>'nullable|mimes:jpeg,png,jpg'
        ]);

        $data=$request->all();
        // check User role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

         //To check brand image file...
        if($request->brand_image != null){
            $file = $request->file('brand_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/brand_image');
            $file->move($destinationPath,$fileName);
            $data['brand_image'] = $fileName;
        }

        if(Brand::create($data)){
            return response()->json([
                'message' => 'Data saved successfully.',
                'brandData'   =>  $data
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
        $brandData = Brand::find($id);
        if(!empty($brandData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'categoryData'   =>  $brandData
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
            'brand_name'=> 'required',
            'brand_image'=> 'nullable|mimes:jpeg,png,jpg'
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        //To fetch single brand data...
        $brandData = Brand::find($id);

        //To check brand image file...
        if($request->brand_image != null){
            //To remove previous file...
            $destinationPath = public_path('uploads/brand_image/');
            if(file_exists($destinationPath.$brandData->brand_image)){
                if($brandData->brand_image != ''){
                    unlink($destinationPath.$brandData->brand_image);
                }
            }

            $file = $request->file('brand_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['brand_image'] = $fileName;
        }

        if($brandData->update($data)){
            return response()->json([
                'message' => 'Data updated successfully.',
                'brandData' =>  $data
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
        // $brand = Brand::find($id);

        // $defaultBrand = Brand::where('is_default', true)->first();
        // $defaultBrandId = $defaultBrand->id;

        //  //To check category is-default or not...
        // if($brand->is_default == false){

        //     if ($brand->brand_image == Null) {

        //        if($brand->delete()){

        //         return response()->json(['message' => 'Data deleted successfully.'], 201);
        //         }else{
        //             return response()->json(['error' => 'Error !! Delete Failed.'], 201);
        //         }

        //     }else{

        //         if (file_exists(public_path('uploads/brand_image/'.$brand->brand_image))) {
        //         unlink(public_path('uploads/brand_image/'.$brand->brand_image));
        //         }

        //         if($brand->delete()){
        //             return response()->json(['message' => 'Data deleted successfully.'], 201);
        //         }else{
        //             return response()->json(['error' => 'Error !! Delete Failed.'], 201);
        //         }


        //     }

        //     }else{
        //         return response()->json(['error' => 'Error !! This is default Brand, so you can not delete.!'], 201);
        //     }

        $brandData = Brand::find($id);
        if($brandData->delete()){
            return response()->json([
                'message' => 'Data deleted successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    // to active brand
    public function activeDefaultBrand($id){
        //To get all the brand ids...
        $getAllBrandIds = Brand::pluck('id');
        Brand::whereIn('id', $getAllBrandIds)->update(['is_default' => false]);

        if(Brand::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'Brand default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

     //To inactive default brand...
     public function inActiveDefaultBrand($id)
     {
         if(Brand::where('id', $id)->update(['is_default' => false])){
             return response()->json([
                 'message' => 'brand non-default set successfully.'
             ], 201);
         }else{
             return response()->json([
                 'message'   =>  'Something is wrong.!'
             ], 500);
         }
     }
}
