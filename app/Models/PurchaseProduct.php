<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
        'purchase_id',
        'product_id',
        'product_qty',
        'free_product',
        'total_product',
        'single_product_price',
        'total_product_price',
        'status',
     ];
    

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function purchaseData()
    {
        return $this->belongsTo(Purchase::class,'purchase_id');
    }
    
    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    

    //To fetch all the purchase-product list...
    public static function getPurchaseproductData($purchaseId,$userId)
    {
        $data = PurchaseProduct::where('purchase_id', $purchaseId)->where('user_id', $userId)
                ->with(['purchaseData','productData','userData'])->get();
        return $data;
    }

    //To fetch single purchase-product-data...
    public static function getSinglePurchaseProductData($purchaseProductId)
    {
        $data = PurchaseProduct::where('id', $purchaseProductId)->first();
        return $data;
    }

    //To check purchase-product-form-data...
    public static function checkPurchaseProductFormData($produuctQuantity,$freeProduuctQuantity,$totalProduuctQuantity)
    {
        if($produuctQuantity != null){
            $pQ = $produuctQuantity;
        }else{
            $pQ = 0;
        }
        
        if($freeProduuctQuantity != null){
            $fPQ = $freeProduuctQuantity;
        }else{
            $fPQ = 0;
        }
        
        if($totalProduuctQuantity != null){
            $tPQ = $totalProduuctQuantity;
        }else{
            $tPQ = 0;
        }

        $data = array(
            'produuctQuantity' => $pQ,
            'freeProduuctQuantity' => $fPQ,
            'totalProduuctQuantity' => $tPQ
        );

        return $data;
    }

    //To fetch all the products with purchase and user...
    public static function getAllProductWithPurchaseAndUserId($purchaseId,$userId)
    {
        $data = PurchaseProduct::where('user_id', $userId)->where('purchase_id', $purchaseId)->get();
        return  $data;
    }

    //To fetch single purchase-product-data with productId, purchaseBatchId...
    public static function getSinglePurchaseProductWithPP($productId, $purchaseBatchId)
    {
        $data = PurchaseProduct::where('product_id', $productId)->where('purchase_batch_id', $purchaseBatchId)->first();
        return $data;
    }
}
