<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the Product data...
        // $productData=Product::orderBy('id','desc')->get();
        $productData=Product::with('categoryData','brandData','groupData','unitData','taxData')->get();

        if(!empty($productData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'productData'   =>  $productData,
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
            'category_id'=> 'required',
            'brand_id'=> 'required',
            'group_id'=> 'nullable',
            'unit_id'=> 'required',
            'product_name'=> 'required',
            'product_code'=> 'required',
            'product_details'=> 'required',
            'stock_alert'=> 'required',
        ]);

        $data = $request->all();
        // dd($data);
        $data['solid_product_details'] = strip_tags($request->product_details);
        $data['status'] = 1;

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $data['user_id'] = $userId;

        if($request->product_image){
            $file = $request->file('product_image');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product_image/');
            $file->move($destinationPath,$fileName);
            $data['product_image'] = $fileName;
        }

        if($request->multiple_image1){
            $file1 = $request->file('multiple_image1');
            $fileName1 = time().rand(100000, 999999).'.'.$file1->getClientOriginalExtension();
            $destinationPath1 = public_path('uploads/multiple_image/');
            $file1->move($destinationPath1,$fileName1);
            $data['multiple_image1'] = $fileName1;
        }

        if($request->multiple_image2){
            $file2 = $request->file('multiple_image2');
            $fileName2 = time().rand(100000, 999999).'.'.$file2->getClientOriginalExtension();
            $destinationPath2 = public_path('uploads/multiple_image/');
            $file2->move($destinationPath2,$fileName2);
            $data['multiple_image2'] = $fileName2;
        }

        if($request->multiple_image3){
            $file3 = $request->file('multiple_image3');
            $fileName3 = time().rand(100000, 999999).'.'.$file3->getClientOriginalExtension();
            $destinationPath3 = public_path('uploads/multiple_image/');
            $file3->move($destinationPath3,$fileName3);
            $data['multiple_image3'] = $fileName3;
        }

        if($request->multiple_image4){
            $file4 = $request->file('multiple_image4');
            $fileName4 = time().rand(100000, 999999).'.'.$file4->getClientOriginalExtension();
            $destinationPath4 = public_path('uploads/multiple_image/');
            $file4->move($destinationPath4,$fileName4);
            $data['multiple_image4'] = $fileName4;
        }

        if($products = Product::create($data)){
            return response()->json([
                'message'   =>  'Successfully Product Added.',
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
        $productData = Product::find($id);
        if(!empty($productData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'productData'   =>  $productData
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
            'category_id'=> 'required',
            'brand_id'=> 'required',
            'group_id'=> 'nullable',
            'unit_id'=> 'required',
            'Product_id'=> 'nullable',
            'product_name'=> 'required',
            'product_code'=> 'required',
            'product_details'=> 'required',
            'stock_alert'=> 'required',
        ]);

        $data = $request->all();
        $data['solid_product_details'] = strip_tags($request->product_details);
        $data['status'] = 1;

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }
        $data['user_id'] = $userId;

        $product = Product::find($id);

        if($request->product_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/product_image/');
            if(file_exists($destinationPath.$product->product_image)){
                if($product->product_image != ''){
                    unlink($destinationPath.$product->product_image);
                }
            }

            $file = $request->file('product_image');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['product_image'] = $fileName;
        }


        if($request->multiple_image1){
            //To remove previous file...
            $destinationPath = public_path('uploads/multiple_image/');
            if(file_exists($destinationPath.$product->multiple_image1)){
                if($product->multiple_image1 != ''){
                    unlink($destinationPath.$product->multiple_image1);
                }
            }

            $file = $request->file('multiple_image1');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['multiple_image1'] = $fileName;
        }


        if($request->multiple_image2){
            //To remove previous file...
            $destinationPath = public_path('uploads/multiple_image/');
            if(file_exists($destinationPath.$product->multiple_image2)){
                if($product->multiple_image2 != ''){
                    unlink($destinationPath.$product->multiple_image2);
                }
            }

            $file = $request->file('multiple_image2');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['multiple_image2'] = $fileName;
        }


        if($request->multiple_image3){
            //To remove previous file...
            $destinationPath = public_path('uploads/multiple_image/');
            if(file_exists($destinationPath.$product->multiple_image3)){
                if($product->multiple_image3 != ''){
                    unlink($destinationPath.$product->multiple_image3);
                }
            }

            $file = $request->file('multiple_image3');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['multiple_image3'] = $fileName;
        }


        if($request->multiple_image4){
            //To remove previous file...
            $destinationPath = public_path('uploads/multiple_image/');
            if(file_exists($destinationPath.$product->multiple_image4)){
                if($product->multiple_image4 != ''){
                    unlink($destinationPath.$product->multiple_image4);
                }
            }

            $file = $request->file('multiple_image4');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['multiple_image4'] = $fileName;
        }



        if($product->update($data)){
            return response()->json([
                'message'   =>  'Successfully Product Added.',
                'data'   =>  $data,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something went to be wrong',
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
        $product = Product::find($id);

        if (file_exists(public_path('uploads/product_image/'.$product->product_image))) {
            unlink(public_path('uploads/product_image/'.$product->product_image));
        }

        if($product->delete()){
            return response()->json([
                'message'   =>  'Successfully Product deleted.',
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something went to be wrong',
            ], 500);
        }
    }

    // To Activate productDefault
    function activeDefaultProduct($id){
        //To get all the unit ids...
        $getAllProductIds = Product::pluck('id');
        $getAllProductIds = Product::pluck('id');
        Product::whereIn('id', $getAllProductIds)->update(['status' => false]);

        if(Product::where('id', $id)->update(['status' => true])){
            return response()->json([
                'message' => 'Product active successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    //To inactive default Product...
    public function inActiveDefaultProduct($id)
    {
        if(Product::where('id', $id)->update(['status' => false])){
            return response()->json([
                'message' => 'Product inactive set successfully.'
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.!'
            ], 500);
        }
    }
}
