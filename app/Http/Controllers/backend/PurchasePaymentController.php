<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchasePayment;
use App\Models\PurchaseProduct;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\User;
use App\Models\DuePurchase;
use Carbon\Carbon;
use Auth;
use Spatie\Permission\Models\Permission;
use PDF;
use App\Models\Supplier;

class PurchasePaymentController extends Controller
{

    //To purchase all the products...
    public function purchasePayment(Request $request)
    {
         $currentMonth = Carbon::now()->format('F');
         $currentDate = Carbon::now()->toDateString();
         $userId = Auth::user()->id;
         $purchaseData = Purchase::where('id',$request->selectedPurchaseId)->first();
 
         $data = new PurchasePayment();
         $data->purchase_id = $request->selectedPurchaseId;
         $data->total_product = $request->totalProductQuantity;
         $data->purchase_amount = $request->totalProductAmount;
         $data->paid_amount = $request->paidAmount;
         $data->due_amount = $request->totalProductAmount - $request->paidAmount;
         $data->payment_type = $request->paymentType;
         $data->payment_note = $request->paymentNote;
         $data->purchase_month = $currentMonth;
         $data->purchase_date = $currentDate;
         $data->user_id = $userId;
         $data->supplier_id = $purchaseData->supplier_id;

         
        if($data->save()){
        
            //to fetch all the purchase products
            $purchaseProduct = PurchaseProduct::getPurchaseproductData($data->purchase_id , $data->user_id);

            foreach($purchaseProduct as $product){
                if(isset($product)){
            
                    $singleProduct = PurchaseProduct::getSinglePurchaseProductData($product->id);

                    //To check product is available to stock...
                    if(!empty($this->checkProductIsAvailable($singleProduct->product_id))){
                        $this->updateProductQuantityToStock($singleProduct->product_id,$singleProduct->total_product);
                    }else{
                        $this->saveProductQuantityToStock($singleProduct->product_id,$singleProduct->total_product,$userId);
                    }
                }
            }   

            if($this->updatePurchaseStatus($request->selectedPurchaseId,$request->supplierId)){
                return response()->json([
                    'success'=> 'Product purchase successfully completed.'
                ]);
            }else{
                return response()->json([
                    'error'=> 'Something is wrong.!'
                ]);
            }
        }

    } 

    //To check product is available or not...
    public function checkProductIsAvailable($productId)
    {
        $data = Stock::where('product_id', $productId)->first();
        return $data;
    }

    //To save product quantity to stock....
    public function saveProductQuantityToStock($productId,$totalProduct,$userId)
    {
        $data = new Stock();
        $data->user_id = $userId;
        $data->product_id = $productId;
        $data->stock_qty = $totalProduct;
        $data->save();
    }

    //To update product quantity to stock with product-id...
    public function updateProductQuantityToStock($productId,$totalProduct)
    {
        $data = Stock::where('product_id', $productId)->first();
        $data->stock_qty += $totalProduct;
        $data->save();
    }

    //To update purchase-status...
    public function updatePurchaseStatus($purchaseId, $supplierId)
    {
        $data = Purchase::getSinglePurchaseData($purchaseId);
        $data->purchase_status = true;
        $data->supplier_id = $supplierId;

        if($data->save()){
            return true;
        }else{
            return false;
        }
    }


    //check Stock Product with purchae batch
    public function checkStockProductWithBatch($productId){
        
        $checkProduct = Stock::getProductQuantity($productId);
        return $checkProduct;

    }
     

    //To show purchase-invoice-template...
    public function purchaseInvoice($purchaseId){

        $userId = Auth::user()->id;

        $purchaseData = Purchase::where('id', $purchaseId)->first();
        $purchaseProducts = PurchaseProduct::where('purchase_id',$purchaseData->id)->get();

        $purchasePayment = PurchasePayment::where('purchase_id',$purchaseData->id)->first();

        $supplierData = Supplier::where('id' ,$purchaseData->supplier_id)->first();
        $userData = User::where('id' ,$purchaseData->user_id)->first();


        //To calculate total selling amount...
        $totalPurchaseAmount = $purchasePayment->purchase_amount;
        $dueAmount = $purchasePayment->due_amount;
        $paidAmount = $purchasePayment->paid_amount;

        return view('backend.purchase.invoicePage', compact('purchaseData','purchaseProducts','totalPurchaseAmount','supplierData','userData','dueAmount','paidAmount','purchasePayment'));
    }



    public function purchasePrintPreview($purchaseId){

        $userId = Auth::user()->id;

        $purchaseData = Purchase::where('id', $purchaseId)->first();
        $purchaseProducts = PurchaseProduct::where('purchase_id',$purchaseData->id)->get();

        $purchasePayment = PurchasePayment::where('purchase_id',$purchaseData->id)->first();

        $supplierData = Supplier::where('id' ,$purchaseData->supplier_id)->first();
        $userData = User::where('id' ,$purchaseData->user_id)->first();


        //To calculate total selling amount...
        $totalPurchaseAmount = $purchasePayment->purchase_amount;
        $dueAmount = $purchasePayment->due_amount;
        $paidAmount = $purchasePayment->paid_amount;

        return view('backend.purchase.purchasePrintPreview', compact('purchaseData','purchaseProducts','totalPurchaseAmount','supplierData','userData','dueAmount','paidAmount','purchasePayment'));

    }


     public function pdfDownload($id)
    {   
         $userId = Auth::user()->id;

        $purchaseData = Purchase::where('id', $id)->first();
        $purchaseProducts = PurchaseProduct::where('purchase_id',$purchaseData->id)->get();

        $purchasePayment = PurchasePayment::where('purchase_id',$purchaseData->id)->first();

        $supplierData = Supplier::where('id' ,$purchaseData->supplier_id)->first();
        $userData = User::where('id' ,$purchaseData->user_id)->first();


        //To calculate total selling amount...
        $totalPurchaseAmount = $purchasePayment->purchase_amount;
        $dueAmount = $purchasePayment->due_amount;


        $pdf = PDF::loadView('backend.purchase.pdf',compact('purchaseData','purchaseProducts','totalPurchaseAmount','supplierData','userData','dueAmount'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('purchasePdf.pdf');
    }


    //sell table add customer.....
    public function purchaseTableCustomerAdd(Request $request){

        $data = Purchase::where('id', $request->purchaseId)->first();
        $data->supplier_id = $request->supplierId;

        if($data->save()){
            return response()->json([
                'success'=> 'successfully Supplier Add.'
            ]);

        }else{
            return response()->json([
                'error'=> 'Error ..!'
            ]);
        }
    }


    public function purchaseDueInvoice($purchaseId){

        $userId = Auth::user()->id;

        $purchaseData = Purchase::where('id', $purchaseId)->first();
        $purchaseProducts = PurchaseProduct::where('purchase_id',$purchaseData->id)->get();

        $purchasePayment = PurchasePayment::where('purchase_id',$purchaseData->id)->first();

        $supplierData = Supplier::where('id' ,$purchaseData->supplier_id)->first();
        $userData = User::where('id' ,$purchaseData->user_id)->first();

        $purchaseDuePaymentHistroy = DuePurchase::where('purchase_id',$purchaseId)->get();

        //To calculate total selling amount...
        $totalPurchaseAmount = $purchasePayment->purchase_amount;
        $dueAmount = $purchasePayment->due_amount;
        $paidAmount = $purchasePayment->paid_amount;

        return view('backend.purchase.dueInvoicePage', compact('purchaseData','purchaseDuePaymentHistroy','purchaseProducts','totalPurchaseAmount','supplierData','userData','dueAmount','paidAmount'));

    }


    public function purchaseDuePayment(Request $request){

        $request->validate([
            'due_amount'=> 'required',
            'date'=> 'required',
        ]);

        $data = $request->all();
       $userId = Auth::user()->id;

        $purchaseId = $request->purchase_id;


        if(DuePurchase::create($data)){

           $purchasePayment = PurchasePayment::where('purchase_id',$purchaseId)->first();
           $purchasePayment->due_amount = $purchasePayment->due_amount - $request->due_amount;
           $purchasePayment->paid_amount = $purchasePayment->paid_amount + $request->due_amount;
           $purchasePayment->save();

           return redirect(route('purchase.due'))->with('message','Successfully Payment');
           
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
        }


    }

}
