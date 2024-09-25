<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
        'category_name',
        'category_image',
        'is_default',
    ];

    //To get all the supplier data...
    public static function getAllCategories()
    {
        $data = Category::orderBy('id', 'desc')->get();
        return $data;
    }
}
