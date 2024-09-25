<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class ExpenseCategoryController extends Controller
{   

    function __construct()
    {
         $this->middleware('permission:expense-category-list|expense-category-create|expense-category-edit|expense-category-delete', ['only' => ['index','show']]);
         $this->middleware('permission:expense-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:expense-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:expense-category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::orderBy('id', 'desc')->get();
        return view('backend.expenseCategory.index' ,compact('expenseCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.expenseCategory.create');
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
        $data['user_id'] = Auth::user()->id;

        if(ExpenseCategory::create($data)){

           return redirect(route('expense-category.index'))->with('message','Successfully ExpenseCategory Added');
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
        $expenseCategory = ExpenseCategory::find($id);
        return view('backend.expenseCategory.edit' , compact('expenseCategory'));
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
        
        $ExpenseCategory = ExpenseCategory::find($id);

        if($ExpenseCategory->update($data)){

            return redirect(route('expense-category.index'))->with('message','Successfully ExpenseCategory Updated');
        }else{

            return redirect()->back()->with('error','Error !! Update Failed');
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
        $ExpenseCategory = ExpenseCategory::find($id);

        if($ExpenseCategory->delete()){
            return redirect(route('expense-category.index'))->with('message','Successfully ExpenseCategory Deleted');
        }else{

            return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }

}
