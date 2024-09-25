<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
        'supplier_name',
        'supplier_email',
        'supplier_phone',
        'supplier_address',
        'company_name',
        'note',
    ];

    //To get all the supplier data...
    public static function getAllSupplier()
    {
    

        $data = Supplier::orderBy('id', 'desc')->get();
        return $data;
    }
}
