<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Sell;
use App\Models\SellProduct;
use App\Models\SellPayment;
use App\Models\DueSell;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Spatie\Permission\Models\Permission;

class SellPaymentController extends Controller
{

    //To sell all the products...
    public function sellPayment(Request $request)
    {   
        $currentMonth = Carbon::now()->format('F');
        $currentDate = Carbon::now()->toDateString();
        //To check user role..
        $userId = Auth::user()->id;

        $sellingData = Sell::where('id',$request->selectedSellingId)->first();

        $data = new SellPayment();
        $data->selling_id = $request->selectedSellingId;
        $data->total_product = $request->totalProductQuantity;
        $data->total_amount = $request->totalProductAmount;
        $data->selling_amount = $request->sellingProductAmount;
        $data->tax = $request->sellingTax;
        $data->discount = $request->sellingDiscount;
        $data->special_discount = $request->sellingSpecialDiscount;
        $data->paid_amount = $request->paidAmount;
        $data->due_amount = $request->dueAmount;
        $data->change_amount = $request->changeAmount;
        $data->payment_type = $request->paymentType;
        $data->payment_note = $request->paymentNote;
        $data->selling_month = $currentMonth;
        $data->selling_date = $currentDate;
        $data->user_id = $userId;
        $data->customer_id = $sellingData->customer_id;

        if($data->save()){
            //To add prodct from stock...
            $productStock = $this->subtractProductToStock($data->selling_id,$data->user_id);
            
            if($productStock == true){
                //To update purchase-status...
                $sellingStatus = $this->updateSellingStatus($data->selling_id,$request->customerId);
                if($sellingStatus == true){

                    //To catch purchase id from generated...
                    $sellId = random_int(100000, 999999);

                    //To check purchase is already inserted or not...
                    $getSellData = $this->chackSellIsGenarated($sellId, $userId);
                    $selectedSellingId = $getSellData->id;
                    $generatedNewSellingId = $getSellData->selling_id;

                    //Get all the sell product data...
                    $sellingProductData = SellProduct::getSellProductData($selectedSellingId,$getSellData->user_id);
                    
                    //To calculate total-product-quantity & total-product-price...
                    $totalProductQuantity = 0;
                    $totalProductPrice = 0;
                    if(isset($sellingProductData)){
                        foreach($sellingProductData as $result){
                            $singleData = SellProduct::getSingleSellProductData($result->id);
                            $totalProductQuantity += $singleData->product_qty;
                            $totalProductPrice += $singleData->product_price;
                        }
                    }
                    
                        $customers = Customer::where('user_id', $userId)->get();

                    return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers','generatedNewSellingId'));
                }else{
                    return response()->json([
                        'error'=> 'Something is wrong with sell status changed.!'
                    ]);
                }
               
            }else{
                return response()->json([
                    'error'=> 'Something is wrong to add stock.!'
                ]);
            }
        }
    }

     //To check purchase is generated or not....
     public function chackSellIsGenarated($sellId, $userId)
     {
         $getSellData = Sell::where('selling_id', $sellId)
                      ->where('user_id', $userId)->first();
 
         if($getSellData != null){
             return $getSellData;
         }else{
             $data = new Sell();
             $data->selling_id = $sellId;
             $data->user_id = $userId;
             $data->selling_date = Carbon::now()->toDateString();
             $data->selling_by = Auth::user()->name;
             $data->save();
 
             return $data;
         }
     }

    //To subtract prodct from stock...
    public function subtractProductToStock($sellingId,$userId)
    {
        $getAllProducts = SellProduct::getSellProductData($sellingId,$userId);

        //To fetch single product data...
        if(!empty($getAllProducts)){
            foreach($getAllProducts as $product){
                $singleProduct = SellProduct::getSingleSellProductData($product->id);

                //To check product is available to stock...
                if(!empty($this->checkProductIsAvailable($singleProduct->product_id))){
                    $this->updateProductQuantityToStock($singleProduct->product_id,$singleProduct->product_qty);
                }else{
                    return response()->json([
                        'error'=> 'Product is empty.!'
                    ]);
                }
            }

            return true;
        }else{
            return response()->json([
                'error'=> 'Product is empty.!'
            ]);
        }
    }

    //To check product is available or not...
    public function checkProductIsAvailable($productId)
    {
        $data = Stock::where('product_id', $productId)->first();
        return $data;
    }

    //To update product quantity to stock with product-id...
    public function updateProductQuantityToStock($productId,$totalProduct)
    {
        $data = Stock::where('product_id', $productId)->first();
        $finalProduct = $data->stock_qty - $totalProduct;
        $data->stock_qty = $finalProduct;
        $data->save();
    }

    //To update selling-status...
    public function updateSellingStatus($sellingId,$customerId)
    {
        $data = Sell::getSingleSellData($sellingId);
        $data->selling_status = true;

        if($data->save()){
            return true;
        }else{
            return false;
        }
    }

    //To show selling-invoice-template...
    public function sellInvoice($sellingId){
        $sellData = Sell::where('id', $sellingId)->first();
        $sellProducts = SellProduct::where('selling_id', $sellData->id)->get();
        $sellPayment = SellPayment::where('selling_id', $sellData->id)->first();

        $customerData = Customer::where('id' ,$sellData->customer_id)->first();
        $userData = User::where('id' ,$sellData->user_id)->first();

        //To calculate total selling amount...
        $totalProductAmount = $sellPayment->total_amount;
        $totalTax = $sellPayment->tax;
        $dueAmount = $sellPayment->due_amount;
        $paidAmount = $sellPayment->paid_amount;
        $discount = $sellPayment->discount;
        $subTotal = $sellPayment->selling_amount;
        $changeAmount = $sellPayment->change_amount;
        $specialDiscount = $sellPayment->special_discount;


        return view('backend.sell.invoicePage', compact('sellData','sellProducts','customerData','userData','totalProductAmount','totalTax','dueAmount','subTotal','discount','paidAmount','changeAmount','specialDiscount','sellPayment'));
    }


    public function sellPrintPreview($sellingId){

        $sellData = Sell::where('id', $sellingId)->first();
        $sellProducts = SellProduct::where('selling_id', $sellData->id)->get();
        $sellPayment = SellPayment::where('selling_id', $sellData->id)->first();

        $customerData = Customer::where('id' ,$sellData->customer_id)->first();
        $userData = User::where('id' ,$sellData->user_id)->first();

        //To calculate total selling amount...
        $totalProductAmount = $sellPayment->total_amount;
        $totalTax = $sellPayment->tax;
        $dueAmount = $sellPayment->due_amount;
        $paidAmount = $sellPayment->paid_amount;
        $discount = $sellPayment->discount;
        $subTotal = $sellPayment->selling_amount;
        $changeAmount = $sellPayment->change_amount;
        $specialDiscount = $sellPayment->special_discount;


        return view('backend.sell.printPreviewPage', compact('sellData','sellProducts','customerData','userData','totalProductAmount','totalTax','dueAmount','subTotal','discount','paidAmount','changeAmount','specialDiscount','sellPayment'));
    }
    


    //sell table add customer.....
    public function sellTableCustomerAdd(Request $request){

        $data = Sell::getSingleSellData($request->sellingId);
        $data->customer_id = $request->customerId;

        if($data->save()){

            return response()->json([
                'success'=> 'successfully Customer Add.'
            ]);

        }else{
            return response()->json([
                'error'=> 'Error ..!'
            ]);
        }
    }

    public function sellDueInvoice($sellingId){

        $sellData = Sell::where('id', $sellingId)->first();
        $sellProducts = SellProduct::where('selling_id', $sellData->id)->get();
        $sellPayment = SellPayment::where('selling_id', $sellData->id)->first();

        $customerData = Customer::where('id' ,$sellData->customer_id)->first();
        $userData = User::where('id' ,$sellData->user_id)->first();

        //To calculate total selling amount...
        $totalProductAmount = $sellPayment->total_amount;
        $totalTax = $sellPayment->tax;
        $dueAmount = $sellPayment->due_amount;
        $paidAmount = $sellPayment->paid_amount;
        $discount = $sellPayment->discount;
        $subTotal = $sellPayment->selling_amount;

        $sellDuePaymentHistroy = DueSell::where('sell_id',$sellingId)->get();

        return view('backend.sell.dueInvoicePage', compact('sellData','sellDuePaymentHistroy','sellProducts','customerData','userData','totalProductAmount','totalTax','dueAmount','subTotal','discount','paidAmount'));

    }


    public function sellDuePayment(Request $request){

        $request->validate([
            'due_amount'=> 'required',
            'date'=> 'required',
        ]);

        $data = $request->all();
        //To check user role..
        $userId = Auth::user()->id;

        $sellId = $request->sell_id;


        if(DueSell::create($data)){

           $sellPayment = SellPayment::where('selling_id',$sellId)->first();
           $sellPayment->due_amount = $sellPayment->due_amount - $request->due_amount;
           $sellPayment->paid_amount = $sellPayment->paid_amount + $request->due_amount;
           $sellPayment->save();

           return redirect(route('sell.due'))->with('message','Successfully Payment');
           
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
        }

    }
}
