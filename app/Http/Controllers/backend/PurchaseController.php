<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseProduct;
use App\Models\PurchaseBatch;
use App\Models\PurchaseDetail;
use App\Models\PurchasePayment;
use App\Models\Category;
use App\Models\Brand;
use Carbon\Carbon;
use Auth;
use DB;
use Spatie\Permission\Models\Permission;


class PurchaseController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:purchase-list|purchase-create|purchase-edit|purchase-delete', ['only' => ['index','show']]);
         $this->middleware('permission:purchase-create', ['only' => ['create','store']]);
         $this->middleware('permission:purchase-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:purchase-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {           
        $purchases = Purchase::orderBy('id', 'desc')->where('purchase_status',1)->get();

        return view('backend.purchase.index' ,compact('purchases'));
    }



    //To fecth purchase page...
    public function create()
    {

        $userId = Auth::user()->id;

        $suppliers = Supplier::getAllSupplier();
        $products = Product::where('status',1)->orderBy('id','desc')->paginate(15);
        $categories = Category::getAllCategories();
        $brands = Brand::getAllBrands();

        $prchaseUniqueId = random_int(1000000, 9999999);

        //To check purchase status...
        $previousPurchase = Purchase::getPendingPurchaseData();
        if(!empty($previousPurchase)){
            Purchase::whereIn('id', $previousPurchase)->delete();
        }

        //To check purchase is already created or not...
        $this->chackPurchaseIsGenarated($prchaseUniqueId, $userId);
        
        return view('backend.purchase.create',compact('suppliers','products','categories','brands','prchaseUniqueId'));
    }


    //To add product details...
    public function addProductDetails(Request $request)
    {

        $userId = Auth::user()->id;

        //To catch purchase id from generated...
        $purchaseId = $request->purchaseId;

        //To check purchase is already inserted or not...
        $getPurchaseData = $this->chackPurchaseIsGenarated($purchaseId, $userId);
        $selectedPurchaseId = $getPurchaseData->id;

        if(!empty($getPurchaseData)){
            //To check already purchase-product exist or not...
            $purchaseProductData = PurchaseProduct::where('product_id', $request->productId)
                ->where('purchase_id',$getPurchaseData->id)
                ->where('user_id', $getPurchaseData->user_id)->first();

                $productInformation = Product::where('id',$request->productId)->first();

            if(empty($purchaseProductData)){

                //To add product to purchase-product list...
                $data = new PurchaseProduct();
                $data->purchase_id = $getPurchaseData->id;
                $data->product_id = $request->productId;
                $data->user_id = $getPurchaseData->user_id;
                $data->product_qty = $request->productQty;
                $data->free_product = $request->freeProduct;
                $data->total_product = $request->totalProduct;
                $data->single_product_price = $productInformation->purchase_price;
                $data->total_product_price = $request->productQty * $productInformation->purchase_price;
                $data->save();

                //Get all the purchase product data...
                $purchaseProductData = PurchaseProduct::getPurchaseproductData($getPurchaseData->id,$getPurchaseData->user_id);

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

                return view('backend.purchase.productPurchaseList', compact('purchaseProductData','totalProductQuantity','totalProductPrice','selectedPurchaseId','suppliers'));
                
            }else{
                return response()->json([
                    'error'=> 'Already product added please increase quantity.!'
                ]);
            }
        }
    }

    //To check purchase is generated or not....
    public function chackPurchaseIsGenarated($purchaseId, $userId)
    {
        //To fecth single purchase data...
        $getPurchaseData = Purchase::getSinglePurchaseDataForCheck($purchaseId,$userId);

        if($getPurchaseData != null){
            return $getPurchaseData;
        }else{
            $data = new Purchase();
            $data->purchase_id = $purchaseId;
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

    //To get all the products with category/brand...
    public function filterProductList(Request $request)
    {
        $userId = Auth::user()->id;

        //To get form data...
        $categoryId = $request->categoryId;
        $brandId = $request->brandId;

        //To check category and brand is null or not...
        $products = $this->checkCategoryOrBrandIsNull($categoryId,$brandId,$userId);

         return view('backend.purchase.filterProductList' ,compact('products'));    

    }

    //To check category and brand is null or not...
    public function checkCategoryOrBrandIsNull($categoryId,$brandId,$userId){
        if($categoryId != null && $brandId != null){
            $productData = Product::where('category_id', $categoryId)
                    ->where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->paginate(15);
        }elseif($categoryId != null && $brandId == null){
            $productData = Product::where('category_id', $categoryId)
                    ->where('user_id', $userId)
                    ->paginate(15);
        }elseif($categoryId == null && $brandId != null){
            $productData = Product::where('brand_id', $brandId)
                    ->where('user_id', $userId)
                    ->paginate(15);
        }else{
            $productData = null;
        }

        return $productData;
    }



    //search product list
    public function searchProductList(Request $request){

        $userId = Auth::user()->id;

        $searchValue = $request->searchValue;

        if($searchValue != null ){
            $products = Product::where('product_name' , 'like' ,'%'.$searchValue.'%')->paginate(15);

            return view('backend.purchase.filterProductList' ,compact('products'));   

        }else{
            $products = null;
        }


    }


    //reset product list
    public function resetProductList(){

        $userId = Auth::user()->id;

        $products = Product::orderBy('id','desc')->paginate(15);
        return view('backend.purchase.filterProductList' ,compact('products'));   

    }

    //get product details purchase id wise
    public function getPurchaseDetails(Request $request){

        $userId = Auth::user()->id;

        $purchaseProductId = $request->purchaseProductId;

        $productDetails = PurchaseProduct::where('id',$purchaseProductId)->first();
        return $productDetails;
    }

    //update product details
    public function updateProductDetails(Request $request){

        $userId = Auth::user()->id;

        $id = $request->purchaseProductId;
        $purchaseProductIn = PurchaseProduct::where('id',$id)->first();
        $productInformation = Product::where('id',$purchaseProductIn->product_id)->first();

        $data = PurchaseProduct::find($id);
        $data->product_qty = $request->productQty;
        $data->free_product = $request->freeProduct;
        $data->total_product = $request->totalProduct;
        $data->total_product_price = $request->productQty * $productInformation->purchase_price;
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

        return view('backend.purchase.productPurchaseList', compact('purchaseProductData','totalProductQuantity','totalProductPrice','selectedPurchaseId','suppliers'));


    }


    //remove purchase product list
    public function purchaseListProductRemove(Request $request){
        
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
            
            return view('backend.purchase.productPurchaseList', compact('purchaseProductData','totalProductQuantity','totalProductPrice','suppliers','selectedPurchaseId'));
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


    public function edit($id)
    {
        $products = Product::get();
        $suppliers = Supplier::get();
        $purchase = Purchase::find($id);

        return view('backend.purchase.create' , compact('products','suppliers','purchase'));
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
        $purchase = Purchase::find($id);
        if($purchase->delete()){

            return redirect(route('purchase.index'))->with('message','Successfully Purchase Deleted');
        }else{

            return redirect()->back()->with('error','Error !! Delete Failed');
        }
    }


    
    public function addNewSupplier(Request $request){

        $data = new Supplier();
        $data->supplier_name = $request->supplierName;
        $data->supplier_email = $request->supplierEmail;
        $data->supplier_phone = $request->supplierPhone;
        $data->company_name = $request->supplierCompany;
        $data->supplier_address = $request->supplierAddress;
        $data->note = $request->Note;

        $userId = Auth::user()->id;

        $data->user_id = $userId;

        if($data->save()){
            $currentSupplierId = $data->id;

            //To fetch single sell data and to update with customer info...
            $singlePurchaseData = Purchase::where('id', $request->purchaseId)->first();
            $singlePurchaseData->supplier_id = $data->id;
            $singlePurchaseData->save();

            $getAllSuppliers = Supplier::getAllSupplier();
            return view('backend.purchase.getAllSupplier', compact('getAllSuppliers','currentSupplierId'));
        }else{
            return response()->json([
                'error'=> 'Something is wrong to add stock.!'
            ]);
        }
    }

    //To get single purchase product data....
    public function singlePurchaseProductData(Request $request)
    {
        $userId = Auth::user()->id;

        //To fetch single purchase data...
        $purchaseData = Purchase::getSinglePurchaseDataForCheck($request->purchaseUniqueId, $userId);
        $data = PurchaseProduct::where('purchase_id', $purchaseData->id)
                ->where('product_id', $request->productId)->first();
                

        if($data != null){
            return response()->json([
                'error'=> 'Product is already added, Please update your quantity.!'
            ]);
        }else{
            return response()->json([
                'success'=> 'Modal will be show.'
            ]);
        }
    }


    public function purchaseDue(){

        $purchasePaymentData = PurchasePayment::orderBy('id', 'desc')->where('due_amount' , '>' , 0)->get();
        return view('backend.purchase.duePurchase', compact('purchasePaymentData'));
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
            return view('backend.purchase.filterProductList' , compact('products'));
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
            return view('backend.purchase.filterProductList' , compact('products'));
        }else{
            return response()->json([
                'error'=> 'You have no product.!'
            ]);
        }

    }
    
}
