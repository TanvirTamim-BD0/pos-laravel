<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Customer;
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

class SellController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sales-list|sales-create|sales-edit|sales-delete', ['only' => ['index','show']]);
         $this->middleware('permission:sales-create', ['only' => ['create','store']]);
         $this->middleware('permission:sales-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sales-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellData = Sell::orderBy('id', 'desc')->where('selling_status',1)->get();
        return view('backend.sell.index' ,compact('sellData'));
    }


    public function create()
    {   
        $userId = Auth::user()->id;

        $products = Product::orderBy('id','desc')->paginate(15);
        $categories = Category::getAllCategories();
        $brands = Brand::getAllBrands();
        $customers = Customer::where('user_id', $userId)->get();
        $stocks = Stock::where('user_id', $userId)->get();

        $sellingUniqueId = random_int(100000, 999999);

        //To check purchase status...
        $previousSellData = Sell::getPendingSellData();
        if(!empty($previousSellData)){
            Sell::whereIn('id', $previousSellData)->delete();
        }

        $getSellData = $this->chackSellIsGenarated($sellingUniqueId, $userId);

        return view('backend.sell.create',compact('products','categories','brands','sellingUniqueId','customers'));
    }



    // add sell product details.....
    public function addSellProductDetails(Request $request)
    {
        $userId = Auth::user()->id;

        //To catch purchase id from generated...
        $sellId = $request->sellId;

        //To check purchase is already inserted or not...
        $getSellData = $this->chackSellIsGenarated($sellId, $userId);
        $selectedSellingId = $getSellData->id;

        if(!empty($getSellData)){
            //To check already purchase-product exist or not...
            $stockProductData = Stock::where('product_id',$request->purchaseProductId)->first();

         if (!empty($stockProductData)) {

            $purchaseProduct = PurchaseProduct::where('product_id',$request->purchaseProductId)->first();

            $sellProductData = SellProduct::where('product_id', $purchaseProduct->product_id)
                ->where('selling_id',$getSellData->id)
                ->where('user_id', $getSellData->user_id)->first();

            if(empty($sellProductData)){

                //To get purchase product stock qty...
                $productStockData = Stock::getProductQuantity($purchaseProduct->product_id);
                $productInformation = Product::where('id',$purchaseProduct->product_id)->first();
                
                if($productStockData->stock_qty > 0){
                    //To add product to purchase-product list...
                    $data = new SellProduct();
                    $data->selling_id = $getSellData->id;
                    $data->user_id = $getSellData->user_id;
                    $data->product_id = $purchaseProduct->product_id;
                    $data->product_qty = 1;
                    $data->product_price = $data->product_qty * $productInformation->selling_price;
                    $data->single_product_price = $productInformation->selling_price;
                    $data->save();
                }else{
                    return response()->json([
                        'error'=> 'You can not sell product, Cause your stock quantity is empty.!'
                    ]);
                }
                
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

            }else{
                return response()->json([
                    'error'=> 'Already product added please increase quantity.!'
                ]);
            }

          }else{
            return response()->json([
                    'error'=> 'Product stock not available.!'
                ]);
          }
        }

        return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers'));


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
    public function sellListProductRemove(Request $request){
        
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

            $customers = Customer::where('user_id', $userId)->get();

             return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers'));

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

    
    //To increment sell product quantity...
    public function incrementSellProduct(Request $request){

        $userId = Auth::user()->id;

        $sellProductId = $request->sellProductId;
        $sellProductIn = SellProduct::where('id',$sellProductId)->first();
        $productInformation = Product::where('id',$sellProductIn->product_id)->first();

        //increment qty ....
        $sellingProduct = SellProduct::where('id',$request->sellProductId)->first();
        $selectedSellingId = $sellingProduct->selling_id;
        $sellingProduct->product_qty += 1;
        $sellingProduct->product_price = $productInformation->selling_price * $sellingProduct->product_qty;
        
        //To get purchase product stock qty...
        $productStockData = Stock::getProductQuantity($sellingProduct->product_id);

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
        $customers = Customer::where('user_id', $userId)->get();

         return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers'));

    }

    //To decrease sell product quantity...
    public function decrementSellProduct(Request $request){

        $userId = Auth::user()->id;

        $sellProductId = $request->sellProductId;
        $sellProductIn = SellProduct::where('id',$sellProductId)->first();
        $productInformation = Product::where('id',$sellProductIn->product_id)->first();

        //decrement qty ....
        $sellingProduct = SellProduct::where('id',$request->sellProductId)->first();
        $selectedSellingId = $sellingProduct->selling_id;
        $sellingProduct->product_qty -= 1;
        $sellingProduct->product_price = $productInformation->selling_price * $sellingProduct->product_qty;
        
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
        $customers = Customer::where('user_id', $userId)->get();

         return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers'));
    }
    
    //To add sell product quantity...
    public function updateSellProductQty(Request $request)
    {
        $userId = Auth::user()->id;

        $sellProductId = $request->sellProductId;
        $sellProductIn = SellProduct::where('id',$sellProductId)->first();
        $productInformation = Product::where('id',$sellProductIn->product_id)->first();

        //decrement qty ....
        $sellingProduct = SellProduct::where('id',$request->sellProductId)->first();
        $selectedSellingId = $sellingProduct->selling_id;
        $sellingProduct->product_qty = $request->sellProductQty;
        
        //To get purchase product stock qty...
        $productStockData = Stock::getProductQuantity($sellingProduct->product_id);

        if($sellingProduct->product_qty > 0){
            if($sellingProduct->product_qty <= $productStockData->stock_qty){
                $sellingProduct->product_price = $productInformation->selling_price * $sellingProduct->product_qty;
                $sellingProduct->save();

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

                $customers = Customer::get();

                return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers'));
            }else{
                $sellingProduct->product_qty = $productStockData->stock_qty;
                $sellingProduct->product_price = $productInformation->selling_price * $sellingProduct->product_qty;
                $sellingProduct->save();

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

                $customers = Customer::get();

                return view('backend.sell.productSellList', compact('sellingProductData','totalProductQuantity','totalProductPrice','selectedSellingId','customers'));
            }
        }else{
            return response()->json([
                'error'=> 'Product can not decrement less than 1.!'
            ]);
        }
    }


    //To get all the products with category/brand...
    public function filterProductList(Request $request)
    {
        $userId = Auth::user()->id;

        //To get form data...
        $categoryId = $request->categoryId;
        $brandId = $request->brandId;

        $products = $this->checkCategoryOrBrandIsNullForProduct($categoryId,$brandId,$userId);

         return view('backend.sell.filterProductList' ,compact('products'));    

    }


     //To check category and brand is null or not...
    public function checkCategoryOrBrandIsNullForProduct($categoryId,$brandId,$userId){
        if($categoryId != null && $brandId != null){
            $productIds = Product::where('category_id', $categoryId)
                    ->where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->paginate(15);
        }elseif($categoryId != null && $brandId == null){
            $productIds = Product::where('category_id', $categoryId)
                    ->where('user_id', $userId)
                    ->paginate(15);
        }elseif($categoryId == null && $brandId != null){
            $productIds = Product::where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->paginate(15);
        }else{
            $productIds = null;
        }

        return $productIds;

    }


    //search product list
    public function searchProductList(Request $request){

         $userId = Auth::user()->id;

        $searchValue = $request->searchValue;

        if($searchValue != null ){
            $products = Product::where('product_name' , 'like' ,'%'.$searchValue.'%')->paginate(15);

            return view('backend.sell.filterProductList' ,compact('products'));   

        }else{
            $products = null;
        }


    }

    //reset product list
    public function resetProductList(){

        $userId = Auth::user()->id;

        $products = Product::orderBy('id','desc')->paginate(15);
        return view('backend.sell.filterProductList' ,compact('products'));   

    }


   
     //To add a new customer...
    public function addNewCustomer(Request $request)
    {
        $data = new Customer();
        $data->customer_name = $request->customerName;
        $data->customer_email = $request->customerEmail;
        $data->customer_phone = $request->customerPhone;
        $data->company_name = $request->customerCompany;
        $data->customer_address = $request->customerAddress;

        //To check user role..
        $userId = Auth::user()->id;

        $data->user_id = $userId;

        if($data->save()){
            $currentCustomerId = $data->id;

            //To fetch single sell data and to update with customer info...
            $getSellId = Sell::where('selling_id', $request->sellId)->first();
            $singleSellData = Sell::getSingleSellData($getSellId->id);
            $singleSellData->customer_id = $data->id;
            $singleSellData->save();


            $getAllCustomers = Customer::getAllCustomer();
            return view('backend.sell.getAllCustomer', compact('getAllCustomers','currentCustomerId'));
        }else{
            return response()->json([
                'error'=> 'Something is wrong to add stock.!'
            ]);
        }
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function sellDue(){

        $sellPaymentData =  SellPayment::orderBy('id', 'desc')->where('due_amount' , '>' , 0)->get();
        return view('backend.sell.dueSell' , compact('sellPaymentData'));
    }


    //To fetch nextPageProductData....
    public function nextPageProductData(Request $request)
    {
        //To get all the product under selected product id...
        $lastProductId = $request->lastProductId;
        $products = Product::orderBy('id','desc')->where('id', '<', $lastProductId)->paginate(15);

        $allproduct = [];
        foreach($products as $product){
            $allproduct[] = Product::where('id',$product->id)->first();
        }

        if(isset($allproduct) && $allproduct != null){
            return view('backend.sell.filterProductList' , compact('products'));
        }else{
            return response()->json([
                'error'=> 'You have no product.!'
            ]);
        }

    }
    
    //To fetch previousPageProductData....
    public function previousPageProductData(Request $request)
    {
        //To get all the product under selected product id...
        $lastProductId = $request->lastProductId;
        $products = Product::orderBy('id','desc')->where('id', '>', $lastProductId)->paginate(15);

        $allproduct = [];
        foreach($products as $product){
            $allproduct[] = Product::where('id',$product->id)->first();
        }

        if(isset($allproduct) && $allproduct != null){
            return view('backend.sell.filterProductList' , compact('products'));
        }else{
            return response()->json([
                'error'=> 'You have no product.!'
            ]);
        }

    }

}
