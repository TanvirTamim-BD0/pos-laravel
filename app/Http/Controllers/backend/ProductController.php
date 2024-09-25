<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;
use App\Models\PurchaseProduct;

class ProductController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete|product-status', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
         $this->middleware('permission:product-status', ['only' => ['status']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $products = Product::orderBy('id', 'desc')->get();
        $categories = Category::orderBy('id', 'desc')->get();

        return view('backend.product.index' ,compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //To get all the basic data...
        $data = $this->getBasicInformation();

        $categories = $data['categories'];
        $brands = $data['brands'];
        $units = $data['units'];
        $randomProductId = rand(100000, 999999);

        return view('backend.product.create' , compact('categories','brands','units','randomProductId'));
    }

    //To fetch all the basic information with user...
    public function getBasicInformation()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();
        $units = Unit::orderBy('id', 'desc')->get();

        $data = array(
            'categories' => $categories,
            'brands' => $brands,
            'units' => $units,
        );

        return $data;
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
            'unit_id'=> 'required',
            'product_name'=> 'required',
            'product_code'=> 'required',
            'purchase_price'=> 'required',
            'selling_price'=> 'required',
            'product_image'=> 'required',
            'stock_alert'=> 'required',
        ]);

        $data = $request->all();
        // dd($data);
        $data['solid_product_details'] = strip_tags($request->product_details);
        $data['status'] = 1;

        //To check user role..
        $userId = Auth::user()->id;

        $data['user_id'] = $userId;

        if($request->product_image){
            $file = $request->file('product_image');
            $fileName = time().rand(100000, 999999).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product_image/');
            $file->move($destinationPath,$fileName);
            $data['product_image'] = $fileName;
        }
        
        if($products = Product::create($data)){

           return redirect(route('product.index'))->with('message','Successfully Product Added');
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::get();
        $brands = Brand::get();
        $units = Unit::get();
        return view('backend.product.edit' , compact('product','categories','brands','units'));
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
            'unit_id'=> 'required',
            'product_name'=> 'required',
            'product_code'=> 'required',
            'purchase_price'=> 'required',
            'selling_price'=> 'required',
            'stock_alert'=> 'required',
        ]);

        $data = $request->all();
        $data['solid_product_details'] = strip_tags($request->product_details);
        $data['status'] = 1;

        $userId = Auth::user()->id;
        
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


        if($product->update($data)){
            return redirect(route('product.index'))->with('message','Successfully Product Updated');
        }else{
            return redirect()->back()->with('error','Error !! Update Failed');;
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
            return redirect(route('product.index'))->with('message','Successfully Product Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }



    public function search(Request $request)
    {
        $products = Product::where('product_code' , 'like' ,'%'.$request->product_code.'%')
                    ->where('product_name', 'like' ,'%'.$request->product_name.'%')
                    ->where('category_id', 'like' ,'%'.$request->category_id.'%')
                    ->paginate(5);

        $categories = Category::get();
        return view('backend.product.index' ,compact('products' ,'categories'));
    }


    //To active product...
    public function productActive($id)
    {
        $product = Product::find($id);
        $product->status = 1;
        $product->save();
        return redirect()->route('product.index')->with('message','Successfully Product Active');
    }

    //To active product...
    public function productInactive($id)
    {
        $product = Product::find($id);
        $product->status = 0;
        $product->save();
        return redirect()->route('product.index')->with('error','Product Inactive');
    }


    public function details($id){

        $product = Product::find($id);
        return view('backend.product.details',compact('product'));
    }

    public function searchProductDetails(Request $request){

        $product = Product::where('product_code',$request->productName)->orWhere('product_name',$request->productName)->first();

        if(!empty($product)){
            $id = $product->id;
            $purchaseProducts = PurchaseProduct::where('product_id',$id)->get();
            return view('backend.product.searchProductDetails' ,compact('product','purchaseProducts'));
        }else{
            return response()->json([
                'error' => 'Sorry you have no data.!'
            ]);
        }
       
    }

}
