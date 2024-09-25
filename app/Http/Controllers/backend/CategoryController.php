<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class CategoryController extends Controller
{   

    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('backend.category.index' ,compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.create');
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
            'category_name'=> 'required',
        ]);

        $data = $request->all();

        //To check user role..
        $data['user_id'] = Auth::user()->id;

        /*if($request->category_image){
            $file = $request->file('category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/category_image/');
            $file->move($destinationPath,$fileName);
            $data['category_image'] = $fileName;
        }*/

        if(Category::create($data)){
           return redirect(route('category.index'))->with('message','Successfully Category Added');
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
        $category = Category::find($id);
        return view('backend.category.edit' , compact('category'));
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
            'category_name'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        $data['user_id'] = Auth::user()->id;

        $category = Category::find($id);
        /*if($request->category_image){
            //To remove previous file...
            $destinationPath = public_path('uploads/category_image/');
            if(file_exists($destinationPath.$category->category_image)){
                if($category->category_image != ''){
                    unlink($destinationPath.$category->category_image);
                }
            }

            $file = $request->file('category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['category_image'] = $fileName;
        }*/

        if($category->update($data)){
            return redirect(route('category.index'))->with('message','Successfully Category Updated');
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
        $category = Category::find($id);
        $defaultCategory = Category::where('is_default', true)->first();
        $defaultCategoryId = $defaultCategory->id;


        //To check category is-default or not...
        if($category->is_default == false){

            //To check product under this category...
            $this->updateProductCategoryId($category->id, $defaultCategoryId);

            if ($category->category_image == Null) {

                if($category->delete()){

                return redirect(route('category.index'))->with('message','Successfully Category Deleted');

                }else{
                    return redirect()->back()->with('error','Error !! Delete Failed');
                }

            }else{

                if (file_exists(public_path('uploads/category_image/'.$category->category_image))) {
                    unlink(public_path('uploads/category_image/'.$category->category_image));
                }

                if($category->delete()){
                    return redirect(route('category.index'))->with('message','Successfully Category Deleted');
                }else{
                    return redirect()->back()->with('error','Error !! Delete Failed');
                }

            }


        }else{
            return redirect()->back()->with('error','Error !! This is default category, so you can not delete.!');
        }
        
    }

    //To update default categoryid into products....
    public function updateProductCategoryId($categoryId,$defaultCategoryId)
    {
        //To check product under this category...
        $getAllProductIds = Product::where('category_id', $categoryId)->pluck('id');
        Product::whereIn('id', $getAllProductIds)->update(['category_id' => $defaultCategoryId]);
    }

    //To active default category...
    public function activeDefaultData($id)
    {
        //To get all the category ids...
        $getAllCategoryIds = Category::pluck('id');

        Category::whereIn('id', $getAllCategoryIds)->update(['is_default' => false]);
        Category::where('id', $id)->update(['is_default' => true]);
        return redirect()->route('category.index');
    }
    
    //To inactive default category...
    public function inDefaultActiveData($id)
    {
        Category::where('id', $id)->update(['is_default' => false]);
        return redirect()->route('category.index');
    }

}
