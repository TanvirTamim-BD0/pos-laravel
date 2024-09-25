<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use App\Models\PurchaseBatch;
use Auth;
use Spatie\Permission\Models\Permission;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::orderBy('id', 'desc')->get();
        return view('backend.stock.index' ,compact('stocks'));
    }



    public function stockAlert()
    {
        $userId = Auth::user()->id;

        $productData = Product::where('user_id', $userId)->get();
        return view('backend.stock.stockAlert' , compact('productData'));
    }

}
