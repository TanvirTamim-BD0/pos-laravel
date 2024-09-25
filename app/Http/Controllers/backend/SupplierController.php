<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class SupplierController extends Controller
{   

    function __construct()
    {
         $this->middleware('permission:supplier-list|supplier-create|supplier-edit|supplier-delete', ['only' => ['index','show']]);
         $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
         $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();

        return view('backend.supplier.index' ,compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.supplier.create');
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
            'supplier_name'=> 'required',
            'supplier_phone'=> 'required|min:11',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if(Supplier::create($data)){

           return redirect(route('supplier.index'))->with('message','Successfully Supplier Added');
        }else{

            return redirect()->back();
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
        $supplier = Supplier::find($id);
        return view('backend.supplier.edit' , compact('supplier'));
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
            'supplier_name'=> 'required',
            'supplier_phone'=> 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $supplier = Supplier::find($id);

        if($supplier->update($data)){

            return redirect(route('supplier.index'))->with('message','Successfully Supplier Updated');
        }else{

           return redirect()->back()->with('error','Error !! Added Failed');
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
        $supplier = Supplier::find($id);
        if($supplier->delete()){

            return redirect(route('supplier.index'))->with('message','Successfully Supplier Deleted');
        }else{

            return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }


    public function search(Request $request)
    {
        $suppliers = Supplier::where('supplier_name' , 'like' ,'%'.$request->supplier_name.'%')
                    ->where('supplier_phone', 'like' ,'%'.$request->supplier_phone.'%')
                    ->paginate(5);

        return view('backend.supplier.index' ,compact('suppliers'));
    }


    //To get customer profile...
    public function getSupplierProfile($id)
    {
        $data = Supplier::find($id);

        $purchaseData = Purchase::where('supplier_id', $id)->get();
        $totalPurchase = Purchase::where('supplier_id', $id)->count();

        return view('backend.supplier.profile.index', compact('data','purchaseData','totalPurchase'));
    }

}
