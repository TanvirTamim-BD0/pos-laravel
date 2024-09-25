<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $fillable = [
    	'purchase_id',
        'supplier_id',
    	'user_id',
    	'total_product',
    	'purchase_amount',
    	'paid_amount',
    	'due_amount',
    	'payment_type',
    	'payment_note',
        'purchase_month',
        'purchase_date',
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function purchaseData()
    {
        return $this->belongsTo(Purchase::class,'purchase_id');
    }

    //To get purchase prodct price with purchase id....
    public static function getPurchaseProductPrice($purchaseId)
    {
        $data = PurchasePayment::where('purchase_id', $purchaseId)->first();
        if(isset($data)){
            return $data->purchase_amount;
        }else{
            $data = null;
            return $data;
        }
    }
}
