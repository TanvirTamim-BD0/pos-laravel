<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellReturn extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
        'sell_id',
        'product_id',
        'return_qty',
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function sellData()
    {
        return $this->belongsTo(Sell::class,'sell_id');
    }
    
    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


}
