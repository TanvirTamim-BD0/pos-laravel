<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sell;
use App\Models\SellProduct;
use App\Models\SellPayment;
use App\Models\SellReturn;
use App\Models\Stock;
use App\Models\Damage;
use Auth;

class SellReturnController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $retrunProducts = SellReturn::orderBy('id', 'desc')->get();
        return view('backend.sellReturn.index' ,compact('retrunProducts'));
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	
    	$sells = Sell::orderBy('id', 'desc')->where('selling_status',1)->where('user_id', Auth::user()->id)->get();
        return view('backend.sellReturn.create', compact('sells'));
    }


    public function sellReturnProductList(Request $request){

    	$sellingID = $request->sellingID;
    	$sellProducts = SellProduct::where('selling_id',$sellingID)->get();

    	 return view('backend.sellReturn.sellProductList' ,compact('sellProducts'));
    }


    public function sellReturnSubmit(Request $request){

    	//To get purchase product stock qty...
        $sellData = SellProduct::where('product_id',$request->productId)->where('selling_id', $request->sellingId)->first();

        //Too check product quantity...
        if($request->returnQty <= $sellData->product_qty){
            
            //to get single stock data...
	        $getStock = Stock::where('product_id' , $request->productId)->first();
	        $getStock->stock_qty += $request->returnQty;
	        $getStock->save();

            //To get single sell-product data...
            $sellProduct = SellProduct::where('selling_id',$request->sellingId)->where('product_id' , $request->productId)->first();
            $singleProductPrice = $sellProduct->selling_price;
            $sellAmount = $singleProductPrice * $request->returnQty;
            $sellProduct->product_qty -= $request->returnQty;
            $sellProduct->product_price -= $sellAmount;
            $sellProduct->save();

            //To modify single sell-payment data...
            $sellPayment = SellPayment::where('selling_id',$request->sellingId)->first();
            $sellPayment->total_amount = $sellPayment->total_amount - $sellAmount;
            $sellPayment->selling_amount = $sellPayment->selling_amount - $sellAmount;
            $sellPayment->paid_amount = $sellPayment->paid_amount - $sellAmount;
            $sellPayment->total_product = $sellPayment->total_product - $request->returnQty;
            $sellPayment->save();

            //To add sell return data...
	        $sellReturn = new SellReturn();
	        $sellReturn->user_id = Auth::user()->id;
	        $sellReturn->sell_id = $request->sellingId;
	        $sellReturn->product_id = $request->productId;
	        $sellReturn->return_qty = $request->returnQty;
	        $sellReturn->save();

        }else{
            return response()->json([
                'error'=> 'Return Product can not increment greater than sell product quantity.!'
            ]);
        }


    }


    public function sellDamageSubmit(Request $request){

        //To get purchase product stock qty...
        $sellData = SellProduct::where('product_id',$request->productId)->where('selling_id', $request->sellingId)->first();

        if($request->returnQty <= $sellData->product_qty){

            $sellProduct = SellProduct::where('selling_id',$request->sellingId)->where('product_id' , $request->productId)->first();
            $singleProductPrice = $sellProduct->selling_price;
            $sellAmount = $singleProductPrice * $request->returnQty;
            $sellProduct->product_qty -= $request->returnQty;
            $sellProduct->product_price -= $sellAmount;
            $sellProduct->save();

            $sellPayment = SellPayment::where('selling_id',$request->sellingId)->first();
            $sellPayment->total_amount -= $sellAmount;
            $sellPayment->selling_amount -= $sellAmount;
            $sellPayment->total_product -= $request->returnQty;
            $sellPayment->paid_amount -= $sellAmount;
            $sellPayment->save();

            $damage = new Damage();
            $damage->user_id = Auth::user()->id;
            $damage->product_id = $request->productId;
            $damage->damage_qty = $request->returnQty;
            $damage->note = $request->note;
            $damage->is_purchase = 0;
            $damage->is_sell = 1;
            $damage->save();

        }else{
            return response()->json([
                'error'=> 'Return Product can not increment greater than sell product quantity.!'
            ]);
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
        $sellReturn = SellReturn::find($id);

       	if($sellReturn->delete()){
            return redirect(route('sell-return.index'))->with('message','Successfully Sell Return Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }
            
        
    }

}
