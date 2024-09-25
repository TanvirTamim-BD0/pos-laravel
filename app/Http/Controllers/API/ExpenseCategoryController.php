<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class ExpenseCategoryController extends Controller
{   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseCategoryData = ExpenseCategory::orderBy('id', 'desc')->get();
        
        if(!empty($expenseCategoryData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'expenseCategoryData'   =>  $expenseCategoryData,
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
            'expense_category'=> 'required',
        ]);

        $data = $request->all();
        
        // check User role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(ExpenseCategory::create($data)){
            return response()->json([
                'message' => 'Data saved successfully.',
                'expenseCategoryData'   =>  $data
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
        $expenseCategoryData = ExpenseCategory::find($id);
        if(!empty($expenseCategoryData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'expenseCategoryData'   =>  $expenseCategoryData
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
            'expense_category'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        
        $expenseCategoryData = ExpenseCategory::find($id);

        if($expenseCategoryData->update($data)){
            return response()->json([
                'message' => 'Data updated successfully.',
                'expenseCategoryData' =>  $data
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
        $expenseCategory = ExpenseCategory::find($id);

        if($expenseCategory->delete()){
            return response()->json([
                'message' => 'Data deleted successfully.'
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Something is wrong.!'
            ], 500);
        }

    }

}
