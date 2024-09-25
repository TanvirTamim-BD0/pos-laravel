<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseProduct;
use App\Models\PurchaseBatch;
use App\Models\PurchaseDetail;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use Carbon\Carbon;
use App\Models\PurchasePayment;
use App\Models\Stock;
use Auth;
use DB;
use Spatie\Permission\Models\Permission;


class PurchaseController extends Controller
{

    public function index()
    {   
        //To fetch all the purchaseData...
        $purchaseData = Purchase::orderBy('id','desc')->with(['supplierData','purchaseProductData','purchasePaymentData','userData'])->get();

        if(!empty($purchaseData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseData'   =>  $purchaseData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }


    //To fecth purchase page...
    public function purchaseGetAllDetails()
    {   
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $productData = Product::getAllProduct();
        $categoryData = Category::getAllCategories();
        $brandData = Brand::getAllBrands();

        $purchaseUniqueId = random_int(1000000, 9999999);

        //To check purchase status...
        $previousPurchase = Purchase::getPendingPurchaseData();
        if(!empty($previousPurchase)){
            Purchase::whereIn('id', $previousPurchase)->delete();
        }

        //To check purchase is already created or not...
        $this->chackPurchaseIsGenarated($purchaseUniqueId, $userId);
        
        if(!empty($purchaseUniqueId)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'productData'   =>  $productData,
                'categoryData'   =>  $categoryData,
                'brandData'   =>  $brandData,
                'purchaseUniqueId'   =>  $purchaseUniqueId,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }


    //get purchase batch....
    public function getBatchProductIdWise($productId){

        $purchaeBatchData = PurchaseBatch::where('product_id',$productId)->get();

        if(!empty($purchaeBatchData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaeBatchData'   =>  $purchaeBatchData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }


    //add purchase batch....
    public function addNewPurchaseProductBatch(Request $request){

         //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        //To fecth single purchase data...
        $getPurchaseData = Purchase::getSinglePurchaseDataForCheck($request->purchaseUniqueId,$userId);

        $data = new PurchaseBatch();
        $randomUniqueNumber = random_int(100000, 999999);
        $data->purchase_id = $getPurchaseData->id;
        $data->product_id = $request->product_id;
        $data->purchase_batch_id = $request->purchase_batch_id.'-'.$randomUniqueNumber;

        if($data->save()){
            //To calculate total-product-quantity & total-product-price...
            $purchaseBatchId = $data->id;
            $productBatch = PurchaseBatch::where('id',$purchaseBatchId)->first();
            
            return response()->json([
                'message'   =>  'Successfully Added data.',
                'productBatch'   =>  $productBatch,
            ], 201);

           
        }else{
             return response()->json([
                'message'   =>  'Sorry Dara Not Inserted.'
            ], 500);
        }
        
    }


    //update purchase batch....
    public function updatePurchaseProductBatch(Request $request , $purchaseBatchId){

         //To fecth single purchase batch data...
        $getSinglePurchaseBatchData = PurchaseBatch::getSinglePurchaseBatchData($purchaseBatchId);

        if($getSinglePurchaseBatchData != null){
            $randomUniqueNumber = random_int(100000, 999999);
            $getSinglePurchaseBatchData->purchase_batch_id = $request->purchase_batch_id.'-'.$randomUniqueNumber;
            $getSinglePurchaseBatchData->save();

            //To calculate total-product-quantity & total-product-price...
            $purchaseBatchId = $getSinglePurchaseBatchData->id;
            $productBatch = PurchaseBatch::where('id',$purchaseBatchId)->first();
            
             if(!empty($purchaseBatchId)){
                 return response()->json([
                    'message'   =>  'Successfully Added data.',
                    'productBatch'   =>  $productBatch,
                ], 201);


            }else{
                return response()->json([
                    'message'   =>  'Sorry you have no data.'
                ], 500);
             }
        }

    }


    //add purchase details....
     public function addPurchaseProductDeatils(Request $request){
         //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        //To catch purchase id from generated...
        $purchaseUniqueId = $request->purchaseUniqueId;

        //To check purchase is already inserted or not...
        $getPurchaseData = $this->chackPurchaseIsGenarated($purchaseUniqueId, $userId);
        $selectedPurchaseId = $getPurchaseData->id;

        if(!empty($getPurchaseData)){
            //To check already purchase-product exist or not...
            $purchaseProductData = PurchaseProduct::where('product_id', $request->productId)
                ->where('purchase_id',$getPurchaseData->id)
                ->where('user_id', $getPurchaseData->user_id)->first();

            if(empty($purchaseProductData)){

                //To add product to purchase-product list...
                $data = new PurchaseProduct();
                $data->purchase_id = $getPurchaseData->id;
                $data->product_id = $request->productId;
                $data->purchase_batch_id = $request->purchaseBatchId;
                $data->user_id = $getPurchaseData->user_id;
                $data->product_qty = $request->productQty;
                $data->free_product = $request->freeProduct;
                $data->total_product = $request->totalProduct;
                $data->total_product_price = $request->totalProductPrice;
                $data->single_product_price = $request->singleProductPrice;
                $data->mrp_price = $request->mrpPrice;
                $data->retail_price = $request->retailPrice;
                $data->selling_price = $request->sellingPrice;
                $data->tax = $request->tax;
                $data->discount = $request->discount;
                $data->producut_menufacture_date = $request->producutMenufactureDate;
                $data->product_expire_date = $request->productExpireDate;
                $data->product_waranty = $request->productWaranty;
                $data->save();

                //Get all the purchase product data...
                $purchaseProductData = PurchaseProduct::getPurchaseproductData($getPurchaseData->id,$getPurchaseData->user_id);
                $suppliers = Supplier::getAllSupplier();

                //To calculate total-product-quantity & total-product-price...
                $totalProductQuantity = 0;
                $totalProductPrice = 0;
                if(isset($purchaseProductData)){
                    foreach($purchaseProductData as $result){
                        $singleData = PurchaseProduct::getSinglePurchaseProductData($result->id);
                        $totalProductQuantity += $singleData->total_product;
                        $totalProductPrice += $singleData->total_product_price;
                    }
                }

                if(!empty($purchaseProductData)){
                 return response()->json([
                    'message'   =>  'Successfully Added data.',
                    'purchaseProductData'   =>  $purchaseProductData,
                    'suppliers'   =>  $suppliers,
                    'totalProductQuantity'   =>  $totalProductQuantity,
                    'totalProductPrice'   =>  $totalProductPrice,
                    'selectedPurchaseId'   =>  $selectedPurchaseId,

                ], 201);
                }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
                 }
                
            }else{
                return response()->json([
                    'error'=> 'Already product added please increase quantity.!'
                ]);
            }
        }


     }


     //To check purchase is generated or not....
    public function chackPurchaseIsGenarated($purchaseUniqueId, $userId)
    {
        //To fecth single purchase data...
        $getPurchaseData = Purchase::getSinglePurchaseDataForCheck($purchaseUniqueId,$userId);

        if($getPurchaseData != null){
            return $getPurchaseData;
        }else{
            $data = new Purchase();
            $data->purchase_id = $purchaseUniqueId;
            $data->user_id = $userId;
            $data->purchase_by = Auth::user()->name;
            $data->purchase_date = Carbon::now()->toDateString();
            
            if($data->save()){
                return $data;
            }else{
                $data = null;
            }
        }
    }


    //update purchase deatils...
    public function updatePurchaseProductDeatils(Request $request){

         //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $id = $request->purchaseProductId;

        $data = PurchaseProduct::find($id);
        $data->product_qty = $request->productQty;
        $data->free_product = $request->freeProduct;
        $data->total_product = $request->totalProduct;
        $data->total_product_price = $request->totalProductPrice;
        $data->single_product_price = $request->singleProductPrice;
        $data->mrp_price = $request->mrpPrice;
        $data->retail_price = $request->retailPrice;
        $data->selling_price = $request->sellingPrice;
        $data->tax = $request->tax;
        $data->discount = $request->discount;
        $data->producut_menufacture_date = $request->producutMenufactureDate;
        $data->product_expire_date = $request->productExpireDate;
        $data->product_waranty = $request->productWaranty;
        $data->save();

        //get selectedPurchaseId ....
        $singlePurchaseProductData = PurchaseProduct::where('id',$id)->where('user_id',$userId)->first();
        $selectedPurchaseId = $singlePurchaseProductData->purchase_id;

        //Get all the purchase product data...
        $purchaseProductData = PurchaseProduct::getPurchaseproductData($selectedPurchaseId,$userId);

        
        //To calculate total-product-quantity & total-product-price...
        $totalProductQuantity = 0;
        $totalProductPrice = 0;
        if(isset($purchaseProductData)){
            foreach($purchaseProductData as $result){
                $singleData = PurchaseProduct::getSinglePurchaseProductData($result->id);
                $totalProductQuantity += $singleData->total_product;
                $totalProductPrice += $singleData->total_product_price;
            }
        }

         $suppliers = Supplier::getAllSupplier();

           if(!empty($purchaseProductData)){
                 return response()->json([
                    'message'   =>  'Successfully Added data.',
                    'purchaseProductData'   =>  $purchaseProductData,
                    'suppliers'   =>  $suppliers,
                    'totalProductQuantity'   =>  $totalProductQuantity,
                    'totalProductPrice'   =>  $totalProductPrice,
                    'selectedPurchaseId'   =>  $selectedPurchaseId,

                ], 201);
            }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
            }
    }



     //To purchase Payment...
     public function purchasePayment(Request $request)
     {
         $currentMonth = Carbon::now()->format('F');
         $currentDate = Carbon::now()->toDateString();
         //To check user role..
         if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
             $userId = Auth::user()->id;
         }
         if(Auth::user()->role == 'manager'){
             $userId = Auth::user()->admin_id;
         }
 
         $data = new PurchasePayment();
         $data->purchase_id = $request->purchase_id;
         $data->total_product = $request->totalProductQuantity;
         $data->purchase_amount = $request->totalProductAmount;
         $data->paid_amount = $request->paidAmount;
         $data->due_amount = $request->totalProductAmount - $request->paidAmount;
         $data->payment_type = $request->paymentType;
         $data->payment_note = $request->paymentNote;
         $data->purchase_month = $currentMonth;
         $data->purchase_date = $currentDate;
         $data->user_id = $userId;
         
        if($data->save()){
        
            //to fetch all the purchase products
            $purchaseProduct = PurchaseProduct::getPurchaseproductData($data->purchase_id , $data->user_id);
            
            foreach($purchaseProduct as $product){
                if(isset($product)){

                //to check product id avaleable in stock with this batch id
                $checkStockProduct = $this->checkStockProductWithBatch($product->product_id,$product->purchase_batch_id);

                if($checkStockProduct != null){
                    $checkStockProduct->stock_qty += $product->total_product;
                    $checkStockProduct->save();
                }else{
                    $newStock = new Stock();
                    $newStock->user_id = $product->user_id;
                    $newStock->product_id = $product->product_id;
                    $newStock->stock_qty = $product->total_product;
                    $newStock->purchase_batch_id = $product->purchase_batch_id;
                    $newStock->save();

                    //to check product id avaleable in stock with this batch id
                    $checkStockProduct = $this->checkStockProductWithBatch($product->product_id,$product->purchase_batch_id);
                    
                    if($checkStockProduct != null){
                        $checkStockProduct->stock_qty += $product->total_product;
                        $checkStockProduct->save();
                    }else{
                        $newStock = new Stock();
                        $newStock->user_id = $product->user_id;
                        $newStock->product_id = $product->product_id;
                        $newStock->stock_qty = $product->total_product;
                        $newStock->purchase_batch_id = $product->purchase_batch_id;
                        $newStock->save();
                    }
                }
            }

            //purchase update status and supplier
            $data = Purchase::where('id', $request->purchase_id)->first();
            $data->purchase_status = true;
            $data->supplier_id = $request->supplier_id;

            if($data->save()){
                return response()->json([
                    'message'   =>  'Successfully Payment Done.',
                    'purchaseData'   =>  $data,
                ], 201);
            }else{
                return response()->json([
                    'error'=> 'Something is wrong.!'
                ]);
            }


        }   
     }


    } 


    //check Stock Product with purchae batch
     public function checkStockProductWithBatch($productId , $purchaseBatchId){
        
        $checkProduct = Stock::getProductQuantity($productId,$purchaseBatchId);
        return $checkProduct;

     }



     public function purchaseProductRemove(Request $request){

        $purchaseProductId = $request->purchaseProductId;
        
        if(isset($purchaseProductId)){
            $singleData = PurchaseProduct::where('id',$purchaseProductId)->first();
            $purchaseId = $singleData->purchase_id;
            $userId = $singleData->user_id;
            $singleData->delete();

            //To calculate total-product-quantity & total-product-price...
            $getTotalProductPriceAndQuantity = $this->getTotalProductPriceAndQuantityAfterDestroy($purchaseId,$userId);

            //Get all the purchase product data...
            $totalProductQuantity = $getTotalProductPriceAndQuantity['totalProductQuantity'];
            $totalProductPrice = $getTotalProductPriceAndQuantity['totalProductPrice'];
            $userId = $getTotalProductPriceAndQuantity['userId'];
            $purchaseProductData = PurchaseProduct::where('purchase_id',$purchaseId)->where('user_id',$userId)->get();

            $selectedPurchaseId = $purchaseId; 
            $suppliers = Supplier::getAllSupplier();
            
            
            if(!empty($purchaseProductData)){
                 return response()->json([
                    'message'   =>  'Successfully Deleted data.',
                    'purchaseProductData'   =>  $purchaseProductData,
                    'suppliers'   =>  $suppliers,
                    'totalProductQuantity'   =>  $totalProductQuantity,
                    'totalProductPrice'   =>  $totalProductPrice,
                    'selectedPurchaseId'   =>  $selectedPurchaseId,

                ], 201);
            }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
            }
        }

     }


      //To calculate total-product-price and quantity after destroy purchase-product...
    public function getTotalProductPriceAndQuantityAfterDestroy($purchaseId,$userId)
    {
        $purchaseProductData = PurchaseProduct::getPurchaseproductData($purchaseId,$userId);

        $totalProductQuantity = 0;
        $totalProductPrice = 0;
        if(!empty($purchaseProductData)){
            foreach($purchaseProductData as $result){
                $data = PurchaseProduct::getSinglePurchaseProductData($result->id);
                $totalProductQuantity += $data->total_product;

                if(isset($data->productDetails)){
                    $totalProductPrice += $data->productDetails->total_product_price;
                }
            }
        }

        $purchaseProductDetailsData = array(
            'totalProductQuantity' => $totalProductQuantity,
            'totalProductPrice' => $totalProductPrice,
            'selectedPurchaseId' => $purchaseId,
            'userId' => $userId
        );

        return $purchaseProductDetailsData;
    }



    //To get all the products with category/brand...
    public function filterProduct(Request $request)
    {
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        //To get form data...
        $categoryId = $request->category_id;
        $brandId = $request->brand_id;

        //To check category and brand is null or not...
        $productData = $this->checkCategoryOrBrandIsNull($categoryId,$brandId,$userId);

         if(!empty($productData)){
                 return response()->json([
                    'message'   =>  'Successfully loaded data.',
                    'productData'   =>  $productData,
                ], 201);
            }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
            }

    }

    //To check category and brand is null or not...
    public function checkCategoryOrBrandIsNull($categoryId,$brandId,$userId){
        if($categoryId != null && $brandId != null){
            $productData = Product::where('category_id', $categoryId)
                    ->where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->get();
        }elseif($categoryId != null && $brandId == null){
            $productData = Product::where('category_id', $categoryId)
                    ->where('user_id', $userId)
                    ->get();
        }elseif($categoryId == null && $brandId != null){
            $productData = Product::where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->get();
        }else{
            $productData = null;
        }

        return $productData;
    }



    //search product
    public function searchProduct(Request $request){

         //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $searchValue = $request->searchValue;

        if($searchValue != null ){
            $productData = Product::where('product_name' , 'like' ,'%'.$searchValue.'%')->get();

            if(!empty($productData)){
                 return response()->json([
                    'message'   =>  'Successfully loaded data.',
                    'productData'   =>  $productData,
                ], 201);
            }else{
                return response()->json([
                    'message'   =>  'Sorry you have no data.'
                ], 500);
            }


        }else{
             return response()->json([
                    'message'   =>  'empty'
                ], 500);
        }


    }

    //To fetch purchase product data with batch and product id...
    public function getCurrentBatchData(Request $request){

        $currentPurchaseBatch = $request->currentPurchaseBatch;
        $productId = $request->productId;

        $purchaeBatchData = PurchaseBatch::where('id',$currentPurchaseBatch)->first();

        $data = PurchaseProduct::where('purchase_id',$purchaeBatchData->purchase_id)->where('purchase_batch_id',$purchaeBatchData->id)->where('product_id',$productId)->first();

        if ($data != null) {
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'purchaseProductData'   =>  $data,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }

    }

    //To show purchase-invoice...
    public function purchaseInvoice(Request $request){

        $purchaseData = Purchase::where('id', $request->purchase_id)->with(['supplierData','userData'])->first();
        $purchaseProducts = PurchaseProduct::where('purchase_id',$purchaseData->id)->with(['productData'])->get();

        $purchasePayment = PurchasePayment::where('purchase_id',$purchaseData->id)->first();

        $supplierData = Supplier::where('id' ,$purchaseData->supplier_id)->first();
        $userData = User::where('id' ,$purchaseData->user_id)->first();


        //To calculate total selling amount...
        $totalPurchaseAmount = $purchasePayment->purchase_amount;
        $dueAmount = $purchasePayment->due_amount;
        $paidAmount = $purchasePayment->paid_amount;

         if(!empty($totalPurchaseAmount)){
            return response()->json([
                'message'   =>  'Successfully sell-invoice data loadeded.',
                'purchaseData'=> $purchaseData,
                'purchaseProductData'=> $purchaseProducts,
                'purchasePayment' =>$purchasePayment,
                'totalPurchaseAmount'   =>  $totalPurchaseAmount,
                'dueAmount'   =>  $dueAmount,
                'paidAmount'   =>  $paidAmount,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }


    }
    
}
