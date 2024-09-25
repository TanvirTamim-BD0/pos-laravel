<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use DB;
use Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseData = Expense::orderBy('id', 'desc')->get();
        
        if(!empty($expenseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'expenseData'   =>  $expenseData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }

    }

   
    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id'=> 'required',
            'expense_name'=> 'required',
            'amount'=> 'required',
            'date'=> 'required',
            'description'=> 'required',
        ]);

        $data = $request->all();

         // check User role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        if(Expense::create($data)){
            return response()->json([
                'message' => 'Data saved successfully.',
                'groupData'   =>  $data
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
        $expenseData = Expense::find($id);
        if(!empty($expenseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'expenseData'   =>  $expenseData
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry there have no data.'
            ], 500);
        }
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_category_id'=> 'required',
            'expense_name'=> 'required',
            'amount'=> 'required',
            'date'=> 'required',
            'description'=> 'required',
        ]);

        $data = $request->all();

         // check User role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $data['user_id'] = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $data['user_id'] = Auth::user()->admin_id;
        }

        $expenseData = Expense::find($id);

        if($expenseData->update($data)){
            return response()->json([
                'message' => 'Data updated successfully.',
                'expenseData' =>  $data
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
       $expenseData = Expense::find($id);

       if($expenseData->delete()){
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
