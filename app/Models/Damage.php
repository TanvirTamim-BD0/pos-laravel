<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'purchase_batch_id',
        'damage_qty',
        'note',
        'is_purchase',
        'is_sell'
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    
    public function purchaseBatchData()
    {
        return $this->belongsTo(PurchaseBatch::class,'purchase_batch_id');
    }

    //Get all the product quantity with product and batch...
    public static function getProductQuantity($productId,$purchaseBatchId)
    {
        $data = Damage::where('product_id', $productId)->where('purchase_batch_id', $purchaseBatchId)->first();
        return $data;
    }
}
