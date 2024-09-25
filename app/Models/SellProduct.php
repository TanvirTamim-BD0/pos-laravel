<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    	'selling_id',
        'product_id',
        'product_qty',
        'product_price',
        'single_product_price',
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function sellData()
    {
        return $this->belongsTo(Sell::class,'selling_id');
    }
    
    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


    //To fetch all the sell-product list...
    public static function getSellProductData($sellingId,$userId)
    {
        $data = SellProduct::where('selling_id', $sellingId)->where('user_id', $userId)
                ->with(['sellData','productData','userData'])->get();
        return $data;
    }
    
    //To fetch all the sell-product list...
    public static function getSingleSellProductData($sellProductId)
    {
        $data = SellProduct::where('id', $sellProductId)->first();
        return $data;
    }
}
