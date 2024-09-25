<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class ExpenseController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index','show']]);
         $this->middleware('permission:expense-create', ['only' => ['create','store']]);
         $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::orderBy('id', 'desc')->get();

        //Total Sell ...
        $totalExpenseData = Expense::orderBy('id', 'desc')->get();
        
        //To calculate total product price and selling price...
        $totalExpensePrice = 0;
        foreach($totalExpenseData as $data){
            $totalExpensePrice += $data->amount;
        }

        return view('backend.expense.index' ,compact('expenses','totalExpensePrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $expenseCategories = ExpenseCategory::get();
        return view('backend.expense.create' , compact('expenseCategories'));
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
            'expense_category_id'=> 'required',
            'expense_name'=> 'required',
            'amount'=> 'required',
            'date'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if(Expense::create($data)){

           return redirect(route('expense.index'))->with('message','Successfully Expense Added');
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
        $expense = Expense::find($id);
        $expenseCategories = ExpenseCategory::get();
        return view('backend.expense.edit' , compact('expense' , 'expenseCategories'));
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
            'expense_category_id'=> 'required',
            'expense_name'=> 'required',
            'amount'=> 'required',
            'date'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $expense = Expense::find($id);

        if($expense->update($data)){

            return redirect(route('expense.index'))->with('message','Successfully Expense Updated');
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
        $expense = Expense::find($id);

        if($expense->delete()){
            return redirect(route('expense.index'))->with('message','Successfully Expense Deleted');
        }else{

           return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }

}
