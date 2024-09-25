<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class BrandController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:brand-list|brand-create|brand-edit|brand-delete', ['only' => ['index','show']]);
         $this->middleware('permission:brand-create', ['only' => ['create','store']]);
         $this->middleware('permission:brand-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->get();

        return view('backend.brand.index' ,compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.brand.create');
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
            'brand_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        $data['user_id'] = Auth::user()->id;

        /*if($request->brand_image){
            $file = $request->file('brand_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/brand_image/');
            $file->move($destinationPath,$fileName);
            $data['brand_image'] = $fileName;
        }*/

        if(Brand::create($data)){
           return redirect(route('brand.index'))->with('message','Successfully Brand Added');
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
        $brand = Brand::find($id);
        return view('backend.brand.edit' , compact('brand'));
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
        ]);

        $data = $request->all();
        //To check user role..
        $data['user_id'] = Auth::user()->id;

        $brand = Brand::find($id);
        /*if($request->brand_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/brand_image/');
            if(file_exists($destinationPath.$brand->brand_image)){
                if($brand->brand_image != ''){
                    unlink($destinationPath.$brand->brand_image);
                }
            }

            $file = $request->file('brand_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['brand_image'] = $fileName;
        }*/

        if($brand->update($data)){
            return redirect(route('brand.index'))->with('message','Successfully Brand Updated');
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
        $brand = Brand::find($id);

        $defaultBrand = Brand::where('is_default', true)->first();
        $defaultBrandId = $defaultBrand->id;

         //To check category is-default or not...
        if($brand->is_default == false){

            //To check product under this brand...
            $this->updateProductBrandId($brand->id, $defaultBrandId);


            if ($brand->brand_image == Null) {

               if($brand->delete()){

                return redirect(route('brand.index'))->with('message','Successfully Brand Deleted');
                }else{

                    return redirect()->back()->with('error','Error !! Delete Failed');
                }

            }else{

                if (file_exists(public_path('uploads/brand_image/'.$brand->brand_image))) {
                unlink(public_path('uploads/brand_image/'.$brand->brand_image));
                }

                if($brand->delete()){
                    return redirect(route('brand.index'))->with('message','Successfully Brand Deleted');
                }else{
                    return redirect()->back()->with('error','Error !! Delete Failed');
                }


            }

            }else{
                return redirect()->back()->with('error','Error !! This is default Brand, so you can not delete.!');
            }

    }


    //To update default brandId into products....
    public function updateProductBrandId($brandId,$defaultBrandId)
    {
        //To check product under this brand...
        $getAllProductIds = Product::where('brand_id', $brandId)->pluck('id');
        Product::whereIn('id', $getAllProductIds)->update(['brand_id' => $defaultBrandId]);
    }


    //To active default brand...
    public function activeDefaultData($id)
    {
        //To get all the brand ids...
        $getAllBrandIds = Brand::pluck('id');

        Brand::whereIn('id', $getAllBrandIds)->update(['is_default' => false]);
        Brand::where('id', $id)->update(['is_default' => true]);
        return redirect()->route('brand.index');
    }

    //To inactive default brand...
    public function inDefaultActiveData($id)
    {
        Brand::where('id', $id)->update(['is_default' => false]);
        return redirect()->route('brand.index');
    }


}
