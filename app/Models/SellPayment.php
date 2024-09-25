<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
    	'selling_id',
        'total_product',
        'total_amount',
        'selling_amount',
        'tax',
        'discount',
        'special_discount',
        'paid_amount',
        'due_amount',
        'change_amount',
        'selling_month',
        'selling_date',
        'payment_type',
        'payment_note'
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function sellData()
    {
        return $this->belongsTo(Sell::class,'selling_id');
    }

    //To get selling prodct price with selling id....
    public static function getSellingProductPrice($sellingId)
    {
        $data = SellPayment::where('selling_id', $sellingId)->first();
        return $data->selling_amount;
    }
}
