<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the class data...
        $categoryData = Category::orderBy('id', 'desc')->get();

        if(!empty($categoryData)){
            return response()->json([
                'message'   =>  'Successfully loaded ata.',
                'categoryData'   =>  $categoryData
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
            'category_name'=> 'required',
            'category_image'=> 'nullable|mimes:jpeg,png,jpg'
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        //To check category image file...
        if($request->category_image != null){
            $file = $request->file('category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/category_image');
            $file->move($destinationPath,$fileName);
            $data['category_image'] = $fileName;
        }

        if(Category::create($data)){
            return response()->json([
                'message' => 'Data saved successfully.',
                'categoryData'   =>  $data
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
        $categoryData = Category::find($id);
        if(!empty($categoryData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'categoryData'   =>  $categoryData
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
            'category_name'=> 'required',
            'category_image'=> 'nullable|mimes:jpeg,png,jpg'
        ]);

        $data = $request->all();
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        //To fetch single category data...
        $categoryData = Category::find($id);

        //To check category image file...
        if($request->category_image != null){
            //To remove previous file...
            $destinationPath = public_path('uploads/category_image/');
            if(file_exists($destinationPath.$categoryData->category_image)){
                if($categoryData->category_image != ''){
                    unlink($destinationPath.$categoryData->category_image);
                }
            }

            $file = $request->file('category_image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$fileName);
            $data['category_image'] = $fileName;
        }

        if($categoryData->update($data)){
            return response()->json([
                'message' => 'Data updated successfully.',
                'categoryData' =>  $data
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
        $categoryData = Category::find($id);
        if($categoryData->delete()){
            return response()->json([
                'message' => 'Data deleted successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    //To active default category...
    public function activeDefaultCategory($id)
    {
        //To get all the category ids...
        $getAllCategoryIds = Category::pluck('id');
        Category::whereIn('id', $getAllCategoryIds)->update(['is_default' => false]);

        if(Category::where('id', $id)->update(['is_default' => true])){
            return response()->json([
                'message' => 'Category default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }

    //To inactive default category...
    public function inActiveDefaultCategory($id)
    {
        if(Category::where('id', $id)->update(['is_default' => false])){
            return response()->json([
                'message' => 'Category non-default set successfully.'
            ], 201);
        }else{
            return response()->json([
				'message'   =>  'Something is wrong.!'
			], 500);
        }
    }
}
