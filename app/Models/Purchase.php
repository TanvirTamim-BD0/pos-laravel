<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
    	'purchase_id',
    	'user_id',
        'supplier_id',
        'purchased_by',
        'purchase_date',
        'purchase_status',
    ];
    

    public function purchasePaymentData()
    {
        return $this->hasOne(PurchasePayment::class,'purchase_id');
    }

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function supplierData()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    
    public function purchaseProductData()
    {
        return $this->hasMany(PurchaseProduct::class,'purchase_id');
    }

    //To fetch pending purchase data...
    public static function getPendingPurchaseData()
    {
         $userId = Auth::user()->id;

        $data = Purchase::where('purchase_status', false)->where('user_id', $userId)->pluck('id');
        return $data;
    }

    //To fetch single purchase data...
    public static function getSinglePurchaseData($purchaseId)
    {
        $data = Purchase::where('id', $purchaseId)->first();
        return $data;
    }
    
    //To fetch single purchase data...
    public static function getSinglePurchaseDataForCheck($purchaseId, $userId)
    {
        $data = Purchase::where('purchase_id', $purchaseId)->where('user_id', $userId)->first();
        return $data;
    }
}
