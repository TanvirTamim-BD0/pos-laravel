<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'brand_id',
        'group_id',
        'unit_id',
        'tax_id',
        'product_name',
        'product_code',
        'purchase_price',
        'selling_price',
        'product_image',
        'product_details',
        'solid_product_details',
        'stock_alert',
        'status',
    ];

    public function categoryData()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brandData()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }


    public function unitData()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    }

    //To get all the product data...
    public static function getAllProduct()
    {
        $data = Product::orderBy('id', 'desc')->where('status', 1)->get();
        return $data;
    }

    //To get single product details...
    public static function getProdctInformation($id)
    {
        $data = Product::where('id', $id)->with(['unitData'])->first();
        return $data;
    }

}