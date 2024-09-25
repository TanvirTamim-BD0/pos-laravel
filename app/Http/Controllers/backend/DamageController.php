<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Damage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Stock;
use App\Models\PurchaseBatch;
use DB;
use Auth;
use Spatie\Permission\Models\Permission;

class DamageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:damage-list|damage-create|damage-edit|damage-delete', ['only' => ['index','show']]);
         $this->middleware('permission:damage-create', ['only' => ['create','store']]);
         $this->middleware('permission:damage-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:damage-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $damages = Damage::orderBy('id', 'desc')->get();
        return view('backend.damage.index' ,compact('damages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('id','desc')->get();
        return view('backend.damage.create' , compact('products'));
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
            'product_id'=> 'required',
            'damage_qty'=> 'required',
            'date'=> 'required',
        ]);

        $data = $request->all();

        $product_id = $request->product_id;
        $getStock = Stock::where('product_id' , $product_id)->first();

        $stockQuantity = $getStock->stock_qty;
        $damage_qty = $request->damage_qty;
        $totalQty = $stockQuantity - $damage_qty;

        $stock = Stock::where('product_id' , $product_id)->first();
        $stock->stock_qty = $totalQty;
        $stock->save();

        $data['user_id'] = Auth::user()->id;
        if(Damage::create($data)){

           return redirect(route('damage.index'))->with('message','Successfully Damage Added');
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
        $damage = Damage::find($id);
        $productId = $damage->product_id;

        $products = Product::where('id',$productId)->get();
        return view('backend.damage.edit' , compact('damage','products'));
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
            'product_id'=> 'required',
            'damage_qty'=> 'required',
            'date'=> 'required',
        ]);


        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $damage = Damage::find($id);

        $product_id = $request->product_id;
        $get_stock = Stock::where('product_id' ,$product_id)->first();

        $stock_quantity = $get_stock->stock_qty;
        $damage_qty = $damage->damage_qty;
        $plus_stock = $stock_quantity + $damage_qty;  

        $damage_qty = $request->damage_qty;
        $total_qty = $plus_stock - $damage_qty;

        $stock = Stock::where('product_id' , $product_id)->first();
        $stock->stock_qty = $total_qty;
        $stock->save();

        if($damage->update($data)){
            return redirect(route('damage.index'))->with('message','Successfully Damage Updated');
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
        $damage = Damage::find($id);
        if($damage->delete()){

            return redirect(route('damage.index'))->with('message','Successfully Damage Deleted');
        }else{

            return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }


    public function getBatchProductWise($id)
    {
        $stockData = Stock::where('product_id',$id)->with('purchaseBatchData')->get();

        //To define an array of products...
        $products = [];
        foreach($stockData as $data){

            $singleStockData = Stock::where('id',$data->id)->first();
            $singleBatchData = PurchaseBatch::where('id',$data->purchase_batch_id)->where('product_id', $data->product_id)->first();

            $products[] = array(
                'singleStockData' => $singleStockData,
                'singleBatchData' => $singleBatchData
            );
        }

        return response()->json($products);
    }
    
}
