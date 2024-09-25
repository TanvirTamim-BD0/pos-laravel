<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
        'brand_name',
        'brand_image',
        'is_default',
    ];

    //To get all the supplier data...
    public static function getAllBrands()
    {
        $data = Brand::orderBy('id', 'desc')->get();
        return $data;
    }
}
