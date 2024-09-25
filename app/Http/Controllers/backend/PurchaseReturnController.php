<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\PurchasePayment;
use App\Models\PurchseReturn;
use App\Models\Stock;
use Auth;

class PurchaseReturnController extends Controller
{
    
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retrunProducts = PurchseReturn::orderBy('id', 'desc')->get();
        return view('backend.purchaseReturn.index' ,compact('retrunProducts'));
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {	
    	$purchases = Purchase::orderBy('id', 'desc')->where('purchase_status',1)->where('user_id', Auth::user()->id)->get();
        return view('backend.purchaseReturn.create', compact('purchases'));
    }


    public function purchaseReturnProductList(Request $request){

    	$purchaseID = $request->purchaseID;
    	$purchaseProducts = PurchaseProduct::where('purchase_id',$purchaseID)->get();

    	 return view('backend.purchaseReturn.purchaeProductList' ,compact('purchaseProducts'));
    }


    public function purchaseReturnSubmit(Request $request){

    	//To get purchase product stock qty...
        $productStockData = Stock::getProductQuantity($request->productId,$request->purchaseBatchId);

        if($request->returnQty <= $productStockData->stock_qty){
            
	        $getStock = Stock::where('product_id' , $request->productId)->first();

	        $stockQuantity = $getStock->stock_qty;
	        $returnQty = $request->returnQty;
	        $totalQty = $stockQuantity - $returnQty;

	        $stock = Stock::where('product_id' , $request->productId)->first();
	        $stock->stock_qty = $totalQty;
	        $stock->save();


            $purchaseProduct = PurchaseProduct::where('purchase_id',$request->purchaseId)->where('product_id' , $request->productId)->first();
            $singleProductPrice = $purchaseProduct->single_product_price;
            $purchaseAmount = $singleProductPrice * $request->returnQty;


            $purchaseProduct = PurchaseProduct::where('purchase_id',$request->purchaseId)->where('product_id' , $request->productId)->first();
            $purchaseProduct->total_product = $purchaseProduct->total_product - $request->returnQty;
            $purchaseProduct->product_qty = $purchaseProduct->product_qty - $request->returnQty;
            $purchaseProduct->total_product_price = $purchaseProduct->total_product_price - $purchaseAmount;
            $purchaseProduct->save();

            $purchasePayment = PurchasePayment::where('purchase_id',$request->purchaseId)->first();
            $purchasePayment->purchase_amount = $purchasePayment->purchase_amount - $purchaseAmount;
            $purchasePayment->save();


	        $purchseReturn = new PurchseReturn();
	        $purchseReturn->user_id = Auth::user()->id;
	        $purchseReturn->purchase_id = $request->purchaseId;
	        $purchseReturn->product_id = $request->productId;
	        $purchseReturn->return_qty = $request->returnQty;
	        $purchseReturn->save();

        }else{
            return response()->json([
                'error'=> 'Return Product can not increment greater than stock quantity.!'
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
        $purchseReturn = PurchseReturn::find($id);

       	if($purchseReturn->delete()){
            return redirect(route('purchase-return.index'))->with('message','Successfully Purchse Return Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }
            
        
    }

}
