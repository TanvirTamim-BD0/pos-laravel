<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'product_id',
        'stock_qty',
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    

    //Get all the product quantity with product and batch...
    public static function getProductQuantity($productId)
    {
        $data = Stock::where('product_id', $productId)->first();
        return $data;
    }

    //To fetch stock count with productId...
    public static function getProductStockCount($productId)
    {   
        $stocks = Stock::where('product_id',$productId)->get();  

        //To calculate stock count...
        $stockCount = 0;
        foreach($stocks as $stock){
            if(isset($stock)){
                $stockCount += $stock->stock_qty;
            }
        }

        return $stockCount;         
    }


}
