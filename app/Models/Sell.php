<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Sell extends Model
{
    use HasFactory;

    protected $fillable = [
    	'selling_id',
        'user_id',
        'customer_id',
        'selling_by',
        'selling_status',
        'selling_date'
    ];

    public function userData()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function parcelData()
    {
        return $this->hasMany(Parcel::class,'parcel_id');
    }

    public function customerData()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function sellProductData()
    {
        return $this->hasMany(SellProduct::class,'selling_id');
    }

    public function sellPaymentData()
    {
        return $this->hasOne(SellPayment::class,'selling_id');
    }

    //To fetch pending sell data...
    public static function getPendingSellData()
    {
        $userId = Auth::user()->id;

        $data = Sell::where('selling_status', false)->where('user_id', $userId)->pluck('id');
        return $data;
    }

    //To fetch single sell data...
    public static function getSingleSellData($sellingId)
    {
        $data = Sell::where('id', $sellingId)->first();
        return $data;
    }

    //To get all the sell...
    public static function getAllSell()
    {
        //To check user role..
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            $userId = Auth::user()->id;
        }
        if(Auth::user()->role == 'manager'){
            $userId = Auth::user()->admin_id;
        }

        $data = Sell::orderBy('id', 'desc')->where('user_id', $userId)->get();
        return $data;
    }
}
