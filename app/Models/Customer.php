<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Customer extends Model
{
    use HasFactory;

     protected $fillable = [
     	'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'company_name',
    ];


    //To get all the customer..
    public static function getAllCustomer()
    {
        
        $data = Customer::orderBy('id', 'desc')->get();
        return $data;
    }
   
    //To get single customer..
    public static function getSingleCustomer($customerId)
    {
        $data = Customer::where('id', $customerId)->first();
        return $data;
    }

}
