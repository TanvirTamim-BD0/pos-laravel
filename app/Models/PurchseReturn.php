<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchseReturn extends Model
{
    use HasFactory;

     protected $fillable = [
    	'user_id',
        'purchase_id',
        'product_id',
        'return_qty',
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

}
