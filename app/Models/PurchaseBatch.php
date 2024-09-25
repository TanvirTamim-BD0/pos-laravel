<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'purchase_batch_id'
    ];

    public function purchaseData()
    {
        return $this->belongsTo(Purchase::class,'purchase_id');
    }
    
    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    //To single purchase batch data......
    public static function getSinglePurchaseBatchData($batchId)
    {
        $data = PurchaseBatch::where('id', $batchId)->first();
        return $data;
    }
    
    //To fetch all the purchase batch with product id...
    public static function getAllPurchaseBatchWithProduct($productId)
    {
        $data = PurchaseBatch::where('product_id', $productId)->get();
        return $data;
    }
}
