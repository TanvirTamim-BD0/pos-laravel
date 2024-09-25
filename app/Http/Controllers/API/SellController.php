<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\PurchaseProduct;
use App\Models\PurchaseBatch;
use App\Models\PurchaseDetail;
use App\Models\Sell;
use App\Models\SellProduct;
use App\Models\SellPayment;
use Carbon\Carbon;
use Auth;
use Spatie\Permission\Models\Permission;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Stock;
use App\Models\User;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //To fetch all the sellData...
        $sellData = Sell::orderBy('id','desc')->with(['customerData','sellProductData','sellPaymentData','userData'])->get();

        if(!empty($sellData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'sellData'   =>  $sellData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }

    //To get all purchase product information for selling purpuse...
    public function sellGetAllDetails()
    {   
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $products = Product::getAllProduct();
        $categories = Category::getAllCategories();
        $brands = Brand::getAllBrands();
        $customerGroups = CustomerGroup::where('user_id', $userId)->get();
        $customers = Customer::where('user_id', $userId)->get();
        $stocks = Stock::where('user_id', $userId)->get();

        //To get all the purchaseBatchIds with userId...
        $purchaseBatchIds = PurchaseProduct::where('user_id', $userId)->groupBy('purchase_batch_id')->select('purchase_batch_id')->pluck('purchase_batch_id');
        $sellingUniqueId = random_int(100000, 999999);

        //To fetch all the purchase batches, prchaseProductData and stockData with productId...
        $productData = [];
        foreach($products as $singleProduct){
            $getSingleProductData = Product::getProdctInformation($singleProduct->id);
            $purchaseBatches = PurchaseBatch::getAllPurchaseBatchWithProduct($singleProduct->id);

            $allBatchData = [];
            foreach($purchaseBatches as $batchData){
                $getSingleBatchData = PurchaseBatch::getSinglePurchaseBatchData($batchData->id);
                $productStockQty = Stock::getProductQuantity($singleProduct->id, $batchData->id);
                $getSinglePurchaseProduct = PurchaseProduct::getSinglePurchaseProductWithPP($singleProduct->id, $batchData->id);

                $allBatchData[] = array(
                    'singleBatchData' => $getSingleBatchData,
                    'productStockQty' => $productStockQty,
                    'getSinglePurchaseProduct' => $getSinglePurchaseProduct
                );
            }

            $productData[] = array(
                'productData' => $getSingleProductData,
                'allBatchData' => $allBatchData
            );
        }

        //To check purchase status...
        $previousSellData = Sell::getPendingSellData();
        if(!empty($previousSellData)){
            Sell::whereIn('id', $previousSellData)->delete();
        }


        if(!empty($sellingUniqueId)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'getProductData'   =>  $productData,
                'categoryData'   =>  $categories,
                'brandData'   =>  $brands,
                'customerGroupData'   =>  $customerGroups,
                'customerData'   =>  $customers,
                'sellingUniqueId'   =>  $sellingUniqueId,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
        
    }

    //To get all the purchase prodct batches...
    public function getPurchaseProductBatch(Request $request)
    {
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        //To fetch single purchase product data with all the bacthes...
        $getSingleProductData = Product::getProdctInformation($request->purchaseProductId);
        $purchaseBatches = PurchaseBatch::getAllPurchaseBatchWithProduct($request->purchaseProductId);

        $allBatchData = [];
        foreach($purchaseBatches as $batchData){
            $getSingleBatchData = null;
            $productStockQty = Stock::getProductQuantity($getSingleProductData->id, $batchData->id);
            $getSinglePurchaseProduct = PurchaseProduct::getSinglePurchaseProductWithPP($getSingleProductData->id, $batchData->id);
            
            if(isset($batchData) && $productStockQty != null){
                $getSingleBatchData = PurchaseBatch::getSinglePurchaseBatchData($batchData->id);

                $allBatchData[] = array(
                    'singleBatchData' => $getSingleBatchData,
                    'productStockQty' => $productStockQty,
                    'getSinglePurchaseProduct' => $getSinglePurchaseProduct
                );
            }
        }

        $productData = array(
            'productData' => $getSingleProductData,
            'allBatchData' => $allBatchData
        );

        //To get customer group and customers data...
        $customerGroups = CustomerGroup::where('user_id', $userId)->get();
        $customers = Customer::where('user_id', $userId)->get();
        $getSellingUniqueId = $request->sellingUniqueId;

        if(!empty($getSingleProductData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'getProductData'   =>  $productData,
                'customerGroupData'   =>  $customerGroups,
                'customerData'   =>  $customers,
                'sellingUniqueId'   =>  $getSellingUniqueId
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }

    //To add sell product data...
    public function addSellDeatils(Request $request){

         //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        //To catch purchase id from generated...
        $sellId = $request->sellingUniqueId;

        //To check purchase is already inserted or not...
        $getSellData = $this->chackSellIsGenarated($sellId, $userId);
        $selectedSellingId = $getSellData->id;

        if(!empty($getSellData)){
            //To check already purchase-product exist or not...
            $stockProductData = Stock::where('product_id',$request->purchaseProductId)->where('purchase_batch_id', $request->currentPurchaseBatchId)->first();
            $purchaseProduct = PurchaseProduct::where('product_id',$request->purchaseProductId)->where('purchase_batch_id', $request->currentPurchaseBatchId)->first();

            $sellProductData = SellProduct::where('product_id', $purchaseProduct->product_id)
                ->where('purchase_batch_id', $request->currentPurchaseBatchId)
                ->where('selling_id',$getSellData->id)
                ->where('user_id', $getSellData->user_id)->first();

            if(empty($sellProductData)){

                //To add product to purchase-product list...
                $data = new SellProduct();
                $data->selling_id = $getSellData->id;
                $data->user_id = $getSellData->user_id;
                $data->product_id = $purchaseProduct->product_id;
                $data->purchase_batch_id = $purchaseProduct->purchase_batch_id;
                $data->product_qty = 1;
                $data->product_price = $data->product_qty * $purchaseProduct->selling_price;
                $data->mrp_price = $purchaseProduct->mrp_price;
                $data->retail_price = $purchaseProduct->retail_price;
                $data->selling_price = $purchaseProduct->selling_price;
                $data->save();


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

                //Customer group and customer data to fetch...
                $customerGroups = CustomerGroup::where('user_id', $userId)->get();
                $customers = Customer::where('user_id', $userId)->get();

            }else{
                return response()->json([
                    'error'=> 'Already product added please increase quantity.!'
                ]);
            }
        }

         if(!empty($sellingProductData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'sellingProductData'   =>  $sellingProductData,
                'totalProductQuantity'   =>  $totalProductQuantity,
                'totalProductPrice'   =>  $totalProductPrice,
                'customerGroupData'   =>  $customerGroups,
                'customerData'   =>  $customers,
                'selectedSellingId'   =>  $selectedSellingId,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
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

    //remove sell product list
    public function sellProductRemove(Request $request){
        
        $sellProductId = $request->sellProductId;
        
        if(isset($sellProductId)){
            $singleData = SellProduct::where('id',$sellProductId)->first();
            $sellingId = $singleData->selling_id;
            $userId = $singleData->user_id;
            $singleData->delete();

            //To calculate total-product-quantity & total-product-price...
            $getTotalProductPriceAndQuantity = $this->getTotalProductPriceAndQuantityAfterDestroy($sellingId,$userId);

            //Get all the purchase product data...
            $totalProductQuantity = $getTotalProductPriceAndQuantity['totalProductQuantity'];
            $totalProductPrice = $getTotalProductPriceAndQuantity['totalProductPrice'];
            $selectedSellingId = $getTotalProductPriceAndQuantity['selectedSellingId'];
            $userId = $getTotalProductPriceAndQuantity['userId'];
            $sellingProductData = SellProduct::getSellProductData($selectedSellingId,$userId); 

             $customerGroupData = CustomerGroup::get();
             $customerData = Customer::get();

             if(!empty($sellingProductData)){
                return response()->json([
                    'message'   =>  'Successfully Deleted data.',
                    'sellingProductData'   =>  $sellingProductData,
                    'totalProductQuantity'   =>  $totalProductQuantity,
                    'totalProductPrice'   =>  $totalProductPrice,
                    'customerGroupData'   =>  $customerGroupData,
                    'customerData'   =>  $customerData,
                    'selectedSellingId'   =>  $selectedSellingId,
                ], 201);
            }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
            }

        }

    }

    //To calculate total-product-price and quantity after destroy purchase-product...
    public function getTotalProductPriceAndQuantityAfterDestroy($sellingId,$userId)
    {
        $sellingProductData = SellProduct::getSellProductData($sellingId,$userId);

        $totalProductQuantity = 0;
        $totalProductPrice = 0;
        if(!empty($sellingProductData)){
            foreach($sellingProductData as $result){
                $data = SellProduct::getSingleSellProductData($result->id);
                $totalProductQuantity += $data->product_qty;
                $totalProductPrice += $data->product_price;
            }
        }

        $sellingProductDetailsData = array(
            'totalProductQuantity' => $totalProductQuantity,
            'totalProductPrice' => $totalProductPrice,
            'selectedSellingId' => $sellingId,
            'userId' => $userId
        );

        return $sellingProductDetailsData;
    }

    //To sell all the products...
    public function sellPayment(Request $request)
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

        $data = new SellPayment();
        $data->selling_id = $request->selling_id;
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

        if($data->save()){
            //To add prodct from stock...
            $productStock = $this->subtractProductToStock($data->selling_id,$data->user_id);
            
            if($productStock == true){
                //To update purchase-status...
                $sellingStatus = $this->updateSellingStatus($data->selling_id,$request->customer_group_id,$request->customer_id);
                if($sellingStatus == true){
                    return response()->json([
                        'success'=> 'Product sell successfully completed.'
                    ]);
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

    //To subtract prodct from stock...
    public function subtractProductToStock($sellingId,$userId)
    {
        $getAllProducts = SellProduct::getSellProductData($sellingId,$userId);

        //To fetch single product data...
        if(!empty($getAllProducts)){
            foreach($getAllProducts as $product){
                $singleProduct = SellProduct::getSingleSellProductData($product->id);

                //To check product is available to stock...
                if(!empty($this->checkProductIsAvailable($singleProduct->product_id,$singleProduct->purchase_batch_id))){
                    $this->updateProductQuantityToStock($singleProduct->product_id,$singleProduct->purchase_batch_id,$singleProduct->product_qty);
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
    public function checkProductIsAvailable($productId,$purchaseBatchId)
    {
        $data = Stock::where('product_id', $productId)->where('purchase_batch_id',$purchaseBatchId)->first();
        return $data;
    }

    //To update product quantity to stock with product-id...
    public function updateProductQuantityToStock($productId,$purchaseBatchId,$totalProduct)
    {
        $data = Stock::where('product_id', $productId)->where('purchase_batch_id',$purchaseBatchId)->first();
        $finalProduct = $data->stock_qty - $totalProduct;
        $data->stock_qty = $finalProduct;
        $data->save();
    }

    //To update selling-status...
    public function updateSellingStatus($sellingId,$customerGroupId,$customerId)
    {
        $data = Sell::getSingleSellData($sellingId);
        $data->customer_group_id = $customerGroupId;
        $data->customer_id = $customerId;
        $data->selling_status = true;

        if($data->save()){
            return true;
        }else{
            return false;
        }
    }

    //To get all the products with category/brand...
    public function sellFilterProduct(Request $request)
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

        $productIds = $this->checkCategoryOrBrandIsNullForProduct($categoryId,$brandId,$userId);

        $purchaseProducts = PurchaseProduct::whereIn('product_id',$productIds)->with(['productData','userData'])->get();

         
        if(!empty($purchaseProducts)){
                return response()->json([
                    'message'   =>  'Successfully Deleted data.',
                    'purchaseProducts'   =>  $purchaseProducts,
                ], 201);
            }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
            }


    }

    //To check category and brand is null or not...
    public function checkCategoryOrBrandIsNullForProduct($categoryId,$brandId,$userId){
        if($categoryId != null && $brandId != null){
            $productIds = Product::where('category_id', $categoryId)
                    ->where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->pluck('id');
        }elseif($categoryId != null && $brandId == null){
            $productIds = Product::where('category_id', $categoryId)
                    ->where('user_id', $userId)
                    ->pluck('id');
        }elseif($categoryId == null && $brandId != null){
            $productIds = Product::where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->pluck('id');
        }else{
            $productIds = null;
        }

        return $productIds;

    }

    //search product list
    public function sellSearchProduct(Request $request){

         //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $searchValue = $request->searchValue;

        if($searchValue != null ){
            $productIds = Product::where('product_name' , 'like' ,'%'.$searchValue.'%')->pluck('id');
            $purchaseProducts = PurchaseProduct::whereIn('product_id',$productIds)->with(['productData','userData'])->get();

            
            if(!empty($purchaseProducts)){
                return response()->json([
                    'message'   =>  'Successfully Deleted data.',
                    'purchaseProducts'   =>  $purchaseProducts,
                ], 201);
            }else{
                    return response()->json([
                        'message'   =>  'Sorry you have no data.'
                    ], 500);
            }


        }else{
            $purchaseProducts = null;
        }


    }

    //To increment sell product quantity...
    public function incrementSellProduct(Request $request){

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $sellProductId = $request->sellProductId;

        //increment qty ....
        $sellingProduct = SellProduct::where('id',$request->sellProductId)->first();
        $selectedSellingId = $sellingProduct->selling_id;
        $sellingProduct->product_qty += 1;
        $sellingProduct->product_price = $sellingProduct->selling_price * $sellingProduct->product_qty;
        
        //To get purchase product stock qty...
        $productStockData = Stock::getProductQuantity($sellingProduct->product_id, $sellingProduct->purchase_batch_id);

        if($sellingProduct->product_qty <= $productStockData->stock_qty){
            $sellingProduct->save();
        }else{
            return response()->json([
                'error'=> 'Product can not increment greater than stock quantity.!'
            ]);
        }

        //Get all the sell product data...
        $sellingProductData = SellProduct::getSellProductData($sellingProduct->selling_id,$userId);
                
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

        //Customer group and customer data to fetch...
        $customerGroups = CustomerGroup::where('user_id', $userId)->get();
        $customers = Customer::where('user_id', $userId)->get();

         if(!empty($sellingProductData)){
            return response()->json([
                'message'   =>  'Successfully updated product quantity.',
                'sellingProductData'   =>  $sellingProductData,
                'totalProductQuantity'   =>  $totalProductQuantity,
                'totalProductPrice'   =>  $totalProductPrice,
                'customerGroupData'   =>  $customerGroups,
                'customerData'   =>  $customers,
                'selectedSellingId'   =>  $selectedSellingId,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }

    //To decrease sell product quantity...
    public function decrementSellProduct(Request $request){

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $sellProductId = $request->sellProductId;

        //decrement qty ....
        $sellingProduct = SellProduct::where('id',$request->sellProductId)->first();
        $selectedSellingId = $sellingProduct->selling_id;
        $sellingProduct->product_qty -= 1;
        $sellingProduct->product_price = $sellingProduct->selling_price * $sellingProduct->product_qty;
        
        if($sellingProduct->product_qty > 0){
            $sellingProduct->save();
        }else{
            return response()->json([
                'error'=> 'Product can not decrement less than 0.1!'
            ]);
        }

        //Get all the sell product data...
        $sellingProductData = SellProduct::getSellProductData($sellingProduct->selling_id,$userId);
                
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

        //Customer group and customer data to fetch...
        $customerGroups = CustomerGroup::where('user_id', $userId)->get();
        $customers = Customer::where('user_id', $userId)->get();

         if(!empty($sellingProductData)){
            return response()->json([
                'message'   =>  'Successfully updated product quantity.',
                'sellingProductData'   =>  $sellingProductData,
                'totalProductQuantity'   =>  $totalProductQuantity,
                'totalProductPrice'   =>  $totalProductPrice,
                'customerGroupData'   =>  $customerGroups,
                'customerData'   =>  $customers,
                'selectedSellingId'   =>  $selectedSellingId,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }

    //To add sell product quantity...
    public function updateSellProductQty(Request $request){

        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $sellProductId = $request->sellProductId;

        //decrement qty ....
        $sellingProduct = SellProduct::where('id',$request->sellProductId)->first();
        $selectedSellingId = $sellingProduct->selling_id;
        $sellingProduct->product_qty = $request->sellProductQty;
        $sellingProduct->product_price = $sellingProduct->selling_price * $sellingProduct->product_qty;
        
        if($sellingProduct->product_qty > 0){
            $sellingProduct->save();
        }else{
            return response()->json([
                'error'=> 'Product can not decrement less than 1.!'
            ]);
        }

        //Get all the sell product data...
        $sellingProductData = SellProduct::getSellProductData($sellingProduct->selling_id,$userId);
                
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

        //Customer group and customer data to fetch...
        $customerGroups = CustomerGroup::where('user_id', $userId)->get();
        $customers = Customer::where('user_id', $userId)->get();

         if(!empty($sellingProductData)){
            return response()->json([
                'message'   =>  'Successfully updated product quantity.',
                'sellingProductData'   =>  $sellingProductData,
                'totalProductQuantity'   =>  $totalProductQuantity,
                'totalProductPrice'   =>  $totalProductPrice,
                'customerGroupData'   =>  $customerGroups,
                'customerData'   =>  $customers,
                'selectedSellingId'   =>  $selectedSellingId,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }


    //To fet all the customer group data...
    public function getAllCustomerGroup(Request $request)
    {
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $customerGroups = CustomerGroup::orderBy('id','DESC')->where('user_id', $userId)->get();

        if(!empty($customerGroups)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'customerGroupData'   =>  $customerGroups,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }


    }
    
    //To fet all the customer group data...
    public function getAllCustomer(Request $request)
    {
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $customerData = Customer::orderBy('id','DESC')->where('user_id', $userId)->where('customer_group_id', $request->customerGroupId)->get();

        if(!empty($customerData)){
            return response()->json([
                'message'   =>  'Successfully loaded data.',
                'customerData'   =>  $customerData,
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }


    }

    //To get sell invoice...
    public function sellInvoice(Request $request, $sellingId)
    {
        $sellData = Sell::where('id', $sellingId)->with(['customerData','userData'])->first();
        $sellProducts = SellProduct::where('selling_id', $sellData->id)->with(['productData','batchData'])->get();
        $sellPayment = SellPayment::where('selling_id', $sellData->id)->first();

        //To calculate total selling amount...
        $totalProductAmount = $sellPayment->total_amount;
        $totalTax = $sellPayment->tax;
        $dueAmount = $sellPayment->due_amount;
        $paidAmount = $sellPayment->paid_amount;
        $discount = $sellPayment->discount;
        $subTotal = $sellPayment->selling_amount;


        if(!empty($sellData)){
            return response()->json([
                'message'   =>  'Successfully sell-invoice data loadeded.',
                'sellData'   =>  $sellData,
                'sellProductData'   =>  $sellProducts,
                'totalProductAmount'   =>  $totalProductAmount,
                'totalTax'   =>  $totalTax,
                'dueAmount'   =>  $dueAmount,
                'discount'   =>  $discount,
                'subTotal'   =>  $subTotal,
                'paidAmount'   =>  $paidAmount
            ], 201);
        }else{
            return response()->json([
                'message'   =>  'Sorry you have no data.'
            ], 500);
        }
    }

}
