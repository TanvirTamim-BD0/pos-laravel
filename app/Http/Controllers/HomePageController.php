<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomePageController extends Controller
{
    public function index()
    {   
        /*$products = Product::where('status',1)->get();
    	return view('frontend.index', compact('products'));*/
        return redirect('/login');
    }
    
}
